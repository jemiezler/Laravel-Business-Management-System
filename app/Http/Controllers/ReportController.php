<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\PerformanceReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Attendance Summary (Last 7 days)
        $attendance_summary = Attendance::select(
            'date',
            DB::raw('count(case when status = "present" then 1 end) as present'),
            DB::raw('count(case when status = "absent" then 1 end) as absent'),
            DB::raw('count(case when status = "late" then 1 end) as late')
        )
            ->where('date', '>=', Carbon::now()->subDays(7)->toDateString())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // 2. Leave Summary (By Type)
        $leave_summary = LeaveRequest::select('leave_type', DB::raw('count(*) as count'))
            ->where('status', 'approved')
            ->groupBy('leave_type')
            ->get();

        // 3. Payroll Monthly Cost (Last 6 months)
        $payroll_summary = Payroll::select(
            DB::raw("DATE_FORMAT(payment_date, '%Y-%m') as month"),
            DB::raw('SUM(net_salary) as total_cost')
        )
            ->where('payment_date', '>=', Carbon::now()->subMonths(6)->toDateString())
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // 4. Performance Distribution
        $performance_summary = PerformanceReview::select('rating', DB::raw('count(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        // 5. Gender distribution (if we had gender, but let's do Department distribution)
        $department_stats = Employee::select('departments.name', DB::raw('count(*) as count'), DB::raw('AVG(employees.salary) as avg_salary'))
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->groupBy('departments.name')
            ->get();

        return view('reports.index', compact(
            'attendance_summary',
            'leave_summary',
            'payroll_summary',
            'performance_summary',
            'department_stats'
        ));
    }
}
