<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $leave_requests = LeaveRequest::with('employee')->latest()->paginate(10);
        return view('leave.index', compact('leave_requests'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('leave.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:annual,sick,unpaid,other',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string',
        ]);

        LeaveRequest::create($validated);

        return redirect()->route('leave.index')->with('status', 'Leave request submitted successfully.');
    }

    public function approve(LeaveRequest $leave_request)
    {
        $leave_request->update([
            'status' => 'approved',
            'approved_by' => \Illuminate\Support\Facades\Auth::id(),
        ]);

        return redirect()->back()->with('status', 'Leave request approved.');
    }

    public function reject(LeaveRequest $leave_request)
    {
        $leave_request->update(['status' => 'rejected']);
        return redirect()->back()->with('status', 'Leave request rejected.');
    }
}
