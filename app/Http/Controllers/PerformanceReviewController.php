<?php

namespace App\Http\Controllers;

use App\Models\PerformanceReview;
use App\Models\Employee;
use Illuminate\Http\Request;

class PerformanceReviewController extends Controller
{
    public function index()
    {
        $reviews = PerformanceReview::with(['employee', 'reviewer'])->latest()->paginate(10);
        return view('performance.index', compact('reviews'));
    }

    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('performance.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'reviewer_id' => 'required|exists:users,id',
            'review_date' => 'required|date',
            'score' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        PerformanceReview::create($validated);

        return redirect()->route('performance.index')->with('status', 'Performance review submitted successfully.');
    }
}
