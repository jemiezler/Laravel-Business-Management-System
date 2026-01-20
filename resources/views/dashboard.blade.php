@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <flux:heading size="xl" level="1">HR Dashboard</flux:heading>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <flux:card class="flex flex-col gap-2">
            <flux:text color="zinc" weight="medium">Total Employees</flux:text>
            <flux:heading size="xl">{{ $stats['total_employees'] }}</flux:heading>
            <flux:text size="sm" color="zinc">Global workforce</flux:text>
        </flux:card>

        <flux:card class="flex flex-col gap-2">
            <flux:text color="green" weight="medium">Active</flux:text>
            <flux:heading size="xl">{{ $stats['active_employees'] }}</flux:heading>
            <flux:text size="sm" color="zinc">Currently working</flux:text>
        </flux:card>

        <flux:card class="flex flex-col gap-2">
            <flux:text color="blue" weight="medium">Today's Attendance</flux:text>
            <flux:heading size="xl">{{ $stats['today_attendance'] }}</flux:heading>
            <flux:text size="sm" color="zinc">Present today</flux:text>
        </flux:card>

        <flux:card class="flex flex-col gap-2">
            <flux:text color="orange" weight="medium">Pending Leaves</flux:text>
            <flux:heading size="xl">{{ $stats['pending_leaves'] }}</flux:heading>
            <flux:text size="sm" color="zinc">Awaiting approval</flux:text>
        </flux:card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <flux:card>
            <flux:heading size="lg" class="mb-4">Department Distribution</flux:heading>
            <div class="space-y-4">
                @forelse($department_distribution as $dept)
                <div class="flex items-center justify-between">
                    <flux:text>{{ $dept->name }}</flux:text>
                    <flux:badge color="zinc">{{ $dept->count }}</flux:badge>
                </div>
                @empty
                <flux:text color="zinc">No department data available</flux:text>
                @endforelse
            </div>
        </flux:card>

        <flux:card>
            <flux:heading size="lg" class="mb-4">Quick Actions</flux:heading>
            <div class="grid grid-cols-2 gap-3">
                <flux:button href="{{ route('employees.create') }}" icon="user-plus">Add Employee</flux:button>
                <flux:button icon="calendar">Mark Attendance</flux:button>
                <flux:button icon="document-text">New Leave Request</flux:button>
                <flux:button icon="credit-card">Process Payroll</flux:button>
            </div>
        </flux:card>
    </div>
</div>
@endsection