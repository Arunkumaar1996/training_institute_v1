<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Admission;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use App\Models\Enquiry;
use App\Models\Payment;
use App\Models\Student;
use App\Models\StudentAttendance;
use App\Models\Trainer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = now()->toDateString();
        $thisMonthStart = now()->startOfMonth()->toDateString();

        // High Level Metrics
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $totalCourses = Course::where('status', 'active')->count();
        $activeBatches = Batch::whereIn('status', ['Upcoming', 'Active'])->count();
        $totalTrainers = Trainer::where('status', 'active')->count();
        $totalEmployees = Employee::where('status', 'active')->count();

        // Financial Metrics
        $todayCollection = Payment::where('payment_date', $today)->where('status', 'completed')->sum('amount');
        $monthCollection = Payment::whereBetween('payment_date', [$thisMonthStart, $today])->where('status', 'completed')->sum('amount');
        $totalCollection = Payment::where('status', 'completed')->sum('amount');
        $totalPendingFees = Admission::where('admission_status', '!=', 'Cancelled')->sum('balance');

        // Lead Metrics
        $totalEnquiries = Enquiry::count();
        $newEnquiries = Enquiry::where('status', 'New')->count();
        $convertedLeads = Enquiry::where('status', 'Converted')->count();
        $conversionRate = $totalEnquiries > 0 ? round(($convertedLeads / $totalEnquiries) * 100, 1) : 0;

        $todayFollowUps = Enquiry::where('follow_up_date', $today)->whereNotIn('status', ['Converted', 'Closed'])->take(5)->get();
        $overdueFollowUps = Enquiry::where('follow_up_date', '<', $today)->whereNotIn('status', ['Converted', 'Closed'])->take(5)->get();

        // Attendance stats for today
        $todayStudentPresent = StudentAttendance::where('attendance_date', $today)->whereIn('status', ['Present', 'Late'])->count();
        $todayStudentTotal = StudentAttendance::where('attendance_date', $today)->count();
        $todayEmployeePresent = EmployeeAttendance::where('attendance_date', $today)->whereIn('status', ['Present', 'Half Day', 'Late'])->count();

        // Chart Data: Monthly Revenue for past 6 months
        $monthlyRevenue = [];
        $monthLabels = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthLabels[] = $month->format('M Y');
            $start = $month->copy()->startOfMonth()->toDateString();
            $end = $month->copy()->endOfMonth()->toDateString();
            $rev = Payment::whereBetween('payment_date', [$start, $end])->where('status', 'completed')->sum('amount');
            $monthlyRevenue[] = (float) $rev;
        }

        // Chart Data: Monthly Admissions for past 6 months
        $monthlyAdmissions = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $start = $month->copy()->startOfMonth()->toDateString();
            $end = $month->copy()->endOfMonth()->toDateString();
            $admCount = Admission::whereBetween('admission_date', [$start, $end])->count();
            $monthlyAdmissions[] = $admCount;
        }

        // Pie Chart 1: Course Enrollment Distribution (Doughnut)
        $coursesDistribution = Course::withCount('admissions')->orderByDesc('admissions_count')->take(5)->get();
        $coursePieLabels = $coursesDistribution->pluck('course_name')->toArray();
        $coursePieData = $coursesDistribution->pluck('admissions_count')->toArray();

        // Pie Chart 2: Lead Status Distribution (Pie)
        $leadStatuses = ['New', 'Contacted', 'Interested', 'Demo Scheduled', 'Converted', 'Closed / Lost'];
        $leadStatusLabels = [];
        $leadStatusData = [];
        foreach ($leadStatuses as $st) {
            $count = Enquiry::where('status', $st)->count();
            if ($count > 0 || in_array($st, ['New', 'Contacted', 'Interested', 'Converted'])) {
                $leadStatusLabels[] = $st;
                $leadStatusData[] = $count;
            }
        }

        // Pie Chart 3: Payment Modes Breakdown (Doughnut)
        $paymentModes = Payment::where('status', 'completed')
            ->select('payment_method', DB::raw('sum(amount) as total_amount'))
            ->groupBy('payment_method')
            ->get();
        $paymentModeLabels = $paymentModes->pluck('payment_method')->toArray();
        $paymentModeData = $paymentModes->pluck('total_amount')->map(fn($v) => (float)$v)->toArray();

        // Extra Tables: Recent 5 Admissions
        $recentAdmissions = Admission::with(['student', 'course', 'batch'])
            ->orderByDesc('id')
            ->take(5)
            ->get();

        // Extra Cards: Upcoming Active Batches
        $upcomingBatches = Batch::with(['course', 'trainer'])
            ->whereIn('status', ['Upcoming', 'Active'])
            ->orderBy('start_date')
            ->take(4)
            ->get();

        // Recent Activity
        $recentActivities = ActivityLog::with('user')->orderByDesc('created_at')->take(10)->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'activeStudents',
            'totalCourses',
            'activeBatches',
            'totalTrainers',
            'totalEmployees',
            'todayCollection',
            'monthCollection',
            'totalCollection',
            'totalPendingFees',
            'totalEnquiries',
            'newEnquiries',
            'convertedLeads',
            'conversionRate',
            'todayFollowUps',
            'overdueFollowUps',
            'todayStudentPresent',
            'todayStudentTotal',
            'todayEmployeePresent',
            'monthLabels',
            'monthlyRevenue',
            'monthlyAdmissions',
            'coursePieLabels',
            'coursePieData',
            'leadStatusLabels',
            'leadStatusData',
            'paymentModeLabels',
            'paymentModeData',
            'recentAdmissions',
            'upcomingBatches',
            'recentActivities'
        ));
    }
}
