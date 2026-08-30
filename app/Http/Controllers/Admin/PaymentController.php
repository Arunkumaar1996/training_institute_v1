<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admission;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\AdmissionFeeService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Payment::with(['student', 'admission.course', 'collector']);

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('payment_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_number', 'like', "%{$search}%")
                  ->orWhere('payment_code', 'like', "%{$search}%")
                  ->orWhere('transaction_number', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('student_code', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->orderByDesc('payment_date')->orderByDesc('id')->paginate(15)->withQueryString();
        $totalCollected = Payment::where('status', 'completed')->sum('amount');

        return view('admin.payments.index', compact('payments', 'totalCollected'));
    }

    public function create(Request $request): View
    {
        $selectedAdmissionId = $request->query('admission_id');
        $admissions = Admission::with(['student', 'course', 'installments'])
            ->where('balance', '>', 0)
            ->where('admission_status', 'Active')
            ->get();

        return view('admin.payments.create', compact('admissions', 'selectedAdmissionId'));
    }

    public function store(Request $request, AdmissionFeeService $feeService): RedirectResponse
    {
        $validated = $request->validate([
            'admission_id' => 'required|exists:admissions,id',
            'fee_installment_id' => 'nullable|exists:fee_installments,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string|in:Cash,UPI,Bank Transfer,Card,Cheque,Online,Other',
            'transaction_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $payment = $feeService->recordPayment($validated);
            return redirect()->route('admin.payments.receipt', $payment->id)->with('success', "Payment receipt #{$payment->receipt_number} generated successfully.");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(int $id): View
    {
        $payment = Payment::with(['student', 'admission.course', 'admission.batch', 'collector'])->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    public function receipt(int $id): View
    {
        $payment = Payment::with(['student', 'admission.course', 'admission.batch', 'collector'])->findOrFail($id);
        return view('admin.payments.receipt', compact('payment'));
    }

    public function destroy(int $id): RedirectResponse
    {
        $payment = Payment::with('admission')->findOrFail($id);
        $admission = $payment->admission;
        $receiptNo = $payment->receipt_number;

        $payment->delete();
        $admission->recalculateTotals();

        ActivityLog::log('deleted', 'Payment', $id, "Payment receipt #{$receiptNo} deleted");

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted and admission balance updated.');
    }
}
