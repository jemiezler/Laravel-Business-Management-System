@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('payroll.index') }}" />
        <flux:heading size="xl" level="1">{{ __('Process Payroll') }}</flux:heading>
    </div>

    <flux:card>
        <form action="{{ route('payroll.store') }}" method="POST" class="space-y-6" x-data="{ 
            basic: 0, 
            allowance: 0, 
            deduction: 0,
            get net() { return (parseFloat(this.basic) || 0) + (parseFloat(this.allowance) || 0) - (parseFloat(this.deduction) || 0) }
        }">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>{{ __('Employee') }}</flux:label>
                    <flux:select name="employee_id" :placeholder="__('Select employee...')" required>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->full_name }} ({{ $employee->employee_id }})</option>
                        @endforeach
                    </flux:select>
                    @error('employee_id') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Period') }}</flux:label>
                    <flux:input name="period" placeholder="January 2026" value="{{ old('period', date('F Y')) }}" required />
                    @error('period') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Basic Salary') }}</flux:label>
                    <flux:input type="number" step="0.01" name="basic_salary" x-model="basic" required />
                    @error('basic_salary') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Allowances') }}</flux:label>
                    <flux:input type="number" step="0.01" name="allowances" x-model="allowance" />
                    @error('allowances') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Deductions') }}</flux:label>
                    <flux:input type="number" step="0.01" name="deductions" x-model="deduction" />
                    @error('deductions') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Net Salary') }}</flux:label>
                    <flux:input type="number" step="0.01" name="net_salary" :value="net" readonly class="bg-zinc-50 dark:bg-zinc-800" />
                    @error('net_salary') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Payment Date') }}</flux:label>
                    <flux:input type="date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" />
                    @error('payment_date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Status') }}</flux:label>
                    <flux:select name="status" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>{{ __('Paid') }}</option>
                    </flux:select>
                    @error('status') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            </div>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('payroll.index') }}" variant="ghost">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('Process Payroll') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>
@endsection