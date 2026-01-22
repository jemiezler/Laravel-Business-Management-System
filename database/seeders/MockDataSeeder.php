<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Payroll;
use App\Models\PerformanceReview;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MockDataSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();
        if ($employees->isEmpty()) {
            $this->call(EmployeeSeeder::class);
            $employees = Employee::all();
        }

        $admin = User::where('role', 'admin')->first();

        foreach ($employees as $employee) {
            // 1. Attendance (Last 30 days)
            for ($i = 0; $i < 30; $i++) {
                $date = Carbon::now()->subDays($i);
                if ($date->isWeekend()) continue;

                $status = fake()->randomElement(['present', 'present', 'present', 'present', 'late', 'absent']);
                $clockIn = null;
                $clockOut = null;

                if ($status !== 'absent') {
                    $clockIn = Carbon::parse($date->format('Y-m-d') . ' 08:00:00')->addMinutes(fake()->numberBetween(0, 90));
                    $clockOut = Carbon::parse($date->format('Y-m-d') . ' 17:00:00')->addMinutes(fake()->numberBetween(-30, 60));
                }

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date->format('Y-m-d'),
                    'clock_in' => $clockIn?->format('H:i:s'),
                    'clock_out' => $clockOut?->format('H:i:s'),
                    'status' => $status,
                ]);
            }

            // 2. Leave Requests
            for ($i = 0; $i < 3; $i++) {
                $start = Carbon::now()->addDays(fake()->numberBetween(-60, 60));
                $end = (clone $start)->addDays(fake()->numberBetween(1, 4));

                LeaveRequest::create([
                    'employee_id' => $employee->id,
                    'leave_type' => fake()->randomElement(['annual', 'sick', 'unpaid']),
                    'start_date' => $start->format('Y-m-d'),
                    'end_date' => $end->format('Y-m-d'),
                    'reason' => fake()->sentence(),
                    'status' => fake()->randomElement(['approved', 'approved', 'pending', 'rejected']),
                    'approved_by' => $admin?->id,
                ]);
            }

            // 3. Payroll (Last 3 months)
            for ($i = 1; $i <= 3; $i++) {
                $basic = $employee->salary;
                $allowance = $basic * 0.1;
                $deduction = $basic * 0.05;

                Payroll::create([
                    'employee_id' => $employee->id,
                    'payment_date' => Carbon::now()->subMonths($i)->endOfMonth()->format('Y-m-d'),
                    'basic_salary' => $basic,
                    'allowances' => $allowance,
                    'deductions' => $deduction,
                    'net_salary' => $basic + $allowance - $deduction,
                    'status' => 'paid',
                ]);
            }

            // 4. Performance Reviews
            PerformanceReview::create([
                'employee_id' => $employee->id,
                'reviewer_id' => $admin?->id,
                'review_date' => Carbon::now()->subMonths(fake()->numberBetween(1, 6))->format('Y-m-d'),
                'rating' => fake()->numberBetween(3, 5),
                'comments' => fake()->paragraph(),
                'kpis' => [
                    'punctuality' => fake()->numberBetween(1, 5),
                    'productivity' => fake()->numberBetween(1, 5),
                    'teamwork' => fake()->numberBetween(1, 5),
                ],
            ]);
        }
    }
}
