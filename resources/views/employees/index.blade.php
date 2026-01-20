@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <flux:heading size="xl" level="1">{{ __('Employees') }}</flux:heading>
        <flux:button href="{{ route('employees.create') }}" variant="primary" icon="plus">{{ __('Add Employee') }}</flux:button>
    </div>

    @if (session('status'))
    <flux:text color="green" class="mb-4">{{ __(session('status')) }}</flux:text>
    @endif

    <flux:card>
        <flux:table :paginate="$employees">
            <flux:table.columns>
                <flux:table.column>{{ __('ID') }}</flux:table.column>
                <flux:table.column>{{ __('Name') }}</flux:table.column>
                <flux:table.column>{{ __('Department') }}</flux:table.column>
                <flux:table.column>{{ __('Job Title') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column>{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($employees as $employee)
                <flux:table.row :key="$employee->id">
                    <flux:table.cell>{{ $employee->employee_id }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:avatar initials="{{ substr($employee->first_name, 0, 1) . substr($employee->last_name, 0, 1) }}" size="xs" />
                            <div>
                                <flux:text weight="medium">{{ $employee->full_name }}</flux:text>
                                <flux:text size="sm" color="zinc">{{ $employee->email }}</flux:text>
                            </div>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>{{ $employee->department->name ?? 'N/A' }}</flux:table.cell>
                    <flux:table.cell>{{ $employee->job_title }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$employee->status === 'active' ? 'green' : ($employee->status === 'inactive' ? 'orange' : 'zinc')">
                            {{ __(ucfirst($employee->status)) }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="flex gap-2">
                            <flux:button variant="ghost" size="sm" icon="pencil-square" href="{{ route('employees.edit', $employee) }}" />
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" onsubmit="return confirm('{{ __(`Are you sure?`) }}')">
                                @csrf
                                @method('DELETE')
                                <flux:button variant="ghost" size="sm" color="red" icon="trash" type="submit" />
                            </form>
                        </div>
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="6" class="text-center py-4">
                        <flux:text color="zinc">{{ __('No employees found.') }}</flux:text>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
@endsection