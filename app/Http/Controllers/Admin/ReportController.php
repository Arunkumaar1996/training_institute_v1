<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admission;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function feesReport(Request $request): View|StreamedResponse
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());
        $courseId = $request->query('course_id');
        $paymentMethod = $request->query('payment_method');

        $query = Payment::with(['student', 'admission.course', 'collector'])
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed');

        if ($courseId) {
            $query->whereHas('admission', function ($q) use ($courseId) {
                $q->where('course_id', $courseId);
            });
        }

        if ($paymentMethod) {
            $query->where('payment_method', $paymentMethod);
        }

        if ($request->query('export') === 'csv') {
            return $this->exportPaymentsCsv($query->get());
        }

        $totalCollected = (clone $query)->sum('amount');
        $totalAmount = $totalCollected;
        $payments = $query->orderByDesc('payment_date')->paginate(20)->withQueryString();
        $courses = Course::where('status', 'active')->get();

        return view('admin.reports.fees', compact('payments', 'courses', 'startDate', 'endDate', 'courseId', 'paymentMethod', 'totalAmount', 'totalCollected'));
    }

    public function admissionsReport(Request $request): View
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());
        $courseId = $request->query('course_id');

        $query = Admission::with(['student', 'course', 'batch'])
            ->whereBetween('admission_date', [$startDate, $endDate]);

        if ($courseId) {
            $query->where('course_id', $courseId);
        }

        $totalFees = (clone $query)->sum('final_fee');
        $totalPaid = (clone $query)->sum('total_paid');
        $totalBalance = (clone $query)->sum('balance');
        $admissions = $query->orderByDesc('admission_date')->paginate(20)->withQueryString();
        $courses = Course::where('status', 'active')->get();

        return view('admin.reports.admissions', compact('admissions', 'courses', 'startDate', 'endDate', 'courseId', 'totalFees', 'totalPaid', 'totalBalance'));
    }

    public function leadsReport(Request $request): View
    {
        $startDate = $request->query('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->query('end_date', now()->toDateString());

        $enquiries = Enquiry::with(['course', 'leadSource', 'source'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $totalEnquiries = Enquiry::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $convertedEnquiries = Enquiry::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->where('status', 'Converted')->count();
        $conversionRate = $totalEnquiries > 0 ? round(($convertedEnquiries / $totalEnquiries) * 100, 1) : 0;

        $bySource = Enquiry::whereBetween('enquiries.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->leftJoin('lead_sources', 'enquiries.lead_source_id', '=', 'lead_sources.id')
            ->selectRaw('lead_sources.name as source_name, count(enquiries.id) as total')
            ->groupBy('lead_sources.name')
            ->get();

        $byStatus = Enquiry::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->get();

        $statusCounts = $byStatus->pluck('total', 'status')->toArray();

        return view('admin.reports.leads', compact(
            'enquiries',
            'startDate',
            'endDate',
            'totalEnquiries',
            'convertedEnquiries',
            'conversionRate',
            'bySource',
            'byStatus',
            'statusCounts'
        ));
    }

    protected function exportPaymentsCsv($payments): StreamedResponse
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="fees_report_' . date('Ymd_His') . '.csv"',
        ];

        return response()->stream(function () use ($payments) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Receipt Number', 'Payment Code', 'Date', 'Student ID', 'Student Name', 'Course', 'Amount', 'Payment Method', 'Transaction Ref']);

            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->receipt_number,
                    $payment->payment_code,
                    $payment->payment_date->format('Y-m-d'),
                    $payment->student?->student_code ?? '',
                    $payment->student?->full_name ?? '',
                    $payment->admission?->course?->course_name ?? '',
                    $payment->amount,
                    $payment->payment_method,
                    $payment->transaction_number ?? '',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
