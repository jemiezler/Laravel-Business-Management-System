@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <flux:heading size="xl" level="1">{{ __('Payroll') }}</flux:heading>
        <flux:button href="{{ route('payroll.create') }}" variant="primary" icon="plus">{{ __('Process Payroll') }}</flux:button>
    </div>

    @if (session('status'))
    <flux:text color="green" class="mb-4">{{ __(session('status')) }}</flux:text>
    @endif

    <flux:card>
        <flux:table :paginate="$payrolls">
            <flux:table.columns>
                <flux:table.column>{{ __('Employee') }}</flux:table.column>
                <flux:table.column>{{ __('Period') }}</flux:table.column>
                <flux:table.column>{{ __('Net Salary') }}</flux:table.column>
                <flux:table.column>{{ __('Payment Date') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($payrolls as $payroll)
                <flux:table.row :key="$payroll->id">
                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:avatar initials="{{ substr($payroll->employee->first_name, 0, 1) . substr($payroll->employee->last_name, 0, 1) }}" size="xs" />
                            <flux:text weight="medium">{{ $payroll->employee->full_name }}</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>{{ $payroll->period }}</flux:table.cell>
                    <flux:table.cell>{{ number_format($payroll->net_salary, 2) }}</flux:table.cell>
                    <flux:table.cell>{{ $payroll->payment_date ? $payroll->payment_date->format('Y-m-d') : '-' }}</flux:table.cell>
                    <flux:table.cell>
                        <flux:badge :color="$payroll->status === 'paid' ? 'green' : 'orange'">
                            {{ __(ucfirst($payroll->status)) }}
                        </flux:badge>
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center py-4">
                        <flux:text color="zinc">{{ __('No payroll records found.') }}</flux:text>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
@endsection