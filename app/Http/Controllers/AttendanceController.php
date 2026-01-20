<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::with('employee')->latest()->paginate(10);
        return view('attendance.index', compact('attendance'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('attendance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'clock_in' => 'nullable',
            'clock_out' => 'nullable',
            'status' => 'required|in:present,absent,late,on_leave',
            'notes' => 'nullable|string',
        ]);

        Attendance::create($validated);

        return redirect()->route('attendance.index')->with('status', 'Attendance recorded successfully.');
    }
}
