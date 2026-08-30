<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Course;
use App\Models\FeeInstallment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Admission::with(['student', 'course', 'batch']);

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($sq) use ($search) {
                $sq->where('first_name', 'like', "%{$search}%")
                   ->orWhere('last_name', 'like', "%{$search}%")
                   ->orWhere('student_code', 'like', "%{$search}%");
            });
        }

        $admissions = $query->orderByDesc('id')->paginate(15)->withQueryString();
        $courses = Course::where('status', 'active')->get();

        $stats = [
            'total_fee' => Admission::sum('final_fee'),
            'total_collected' => Payment::where('status', 'completed')->sum('amount'),
            'total_pending' => Admission::where('admission_status', '!=', 'Cancelled')->sum('balance'),
            'total_overdue' => Admission::where('payment_status', 'Overdue')->sum('balance'),
        ];

        return view('admin.fees.index', compact('admissions', 'courses', 'stats'));
    }

    public function installments(Request $request): View
    {
        $query = FeeInstallment::with(['admission.course', 'student']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $installments = $query->orderBy('due_date')->paginate(15)->withQueryString();
        return view('admin.fees.installments', compact('installments'));
    }

    public function overdueFees(): View
    {
        $overdueAdmissions = Admission::with(['student', 'course', 'batch'])
            ->where('balance', '>', 0)
            ->where('due_date', '<', now()->toDateString())
            ->orderBy('due_date')
            ->paginate(15);

        return view('admin.fees.overdue', compact('overdueAdmissions'));
    }
}
