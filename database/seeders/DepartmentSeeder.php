<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Human Resources', 'description' => 'Managing personnel and employee relations.'],
            ['name' => 'Engineering', 'description' => 'Software development and technical operations.'],
            ['name' => 'Sales & Marketing', 'description' => 'Revenue generation and brand awareness.'],
            ['name' => 'Finance', 'description' => 'Financial planning, accounting, and payroll.'],
            ['name' => 'Legal', 'description' => 'Legal compliance and corporate governance.'],
        ];

        foreach ($departments as $dept) {
            Department::updateOrCreate(['name' => $dept['name']], $dept);
        }
    }
}
