<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'inactive_employees' => Employee::where('status', 'inactive')->count(),
            'resigned_employees' => Employee::where('status', 'resigned')->count(),
            'today_attendance' => Attendance::where('date', now()->toDateString())->where('status', 'present')->count(),
            'pending_leaves' => LeaveRequest::where('status', 'pending')->count(),
        ];

        // Mock data for charts if needed, or simple aggregations
        $department_distribution = Employee::select('departments.name', DB::raw('count(*) as count'))
            ->join('departments', 'employees.department_id', '=', 'departments.id')
            ->groupBy('departments.name')
            ->get();

        return view('dashboard', compact('stats', 'department_distribution'));
    }
}
