<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();

        if ($departments->isEmpty()) {
            $this->call(DepartmentSeeder::class);
            $departments = Department::all();
        }

        $roles = ['Manager', 'Developer', 'Designer', 'HR Specialist', 'Accountant', 'Sales Representative'];

        for ($i = 0; $i < 10; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $email = Str::lower($firstName . '.' . $lastName . '@example.com');

            // Create a user for some employees
            $user = null;
            if ($i < 5) {
                $user = User::create([
                    'name' => "$firstName $lastName",
                    'username' => Str::slug($firstName . $lastName),
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'staff',
                ]);
            }

            Employee::create([
                'user_id' => $user?->id,
                'department_id' => $departments->random()->id,
                'employee_id' => 'EMP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => fake()->phoneNumber(),
                'job_title' => fake()->randomElement($roles),
                'hire_date' => fake()->dateTimeBetween('-2 years', '-6 months'),
                'salary' => fake()->randomFloat(2, 30000, 80000),
                'status' => 'active',
                'address' => fake()->address(),
            ]);
        }
    }
}
