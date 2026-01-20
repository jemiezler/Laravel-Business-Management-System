<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('employee')->latest()->paginate(10);
        return view('payroll.index', compact('payrolls'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('payroll.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'period' => 'required|string',
            'basic_salary' => 'required|numeric',
            'allowances' => 'nullable|numeric',
            'deductions' => 'nullable|numeric',
            'net_salary' => 'required|numeric',
            'payment_date' => 'nullable|date',
            'status' => 'required|in:pending,paid',
        ]);

        Payroll::create($validated);

        return redirect()->route('payroll.index')->with('status', 'Payroll record created successfully.');
    }
}
