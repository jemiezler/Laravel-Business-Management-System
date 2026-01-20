@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('leave.index') }}" />
        <flux:heading size="xl" level="1">{{ __('New Leave Request') }}</flux:heading>
    </div>

    <flux:card>
        <form action="{{ route('leave.store') }}" method="POST" class="space-y-6">
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
                    <flux:label>{{ __('Leave Type') }}</flux:label>
                    <flux:select name="leave_type" required>
                        <option value="annual" {{ old('leave_type') == 'annual' ? 'selected' : '' }}>{{ __('Annual') }}</option>
                        <option value="sick" {{ old('leave_type') == 'sick' ? 'selected' : '' }}>{{ __('Sick') }}</option>
                        <option value="unpaid" {{ old('leave_type') == 'unpaid' ? 'selected' : '' }}>{{ __('Unpaid') }}</option>
                        <option value="other" {{ old('leave_type') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                    </flux:select>
                    @error('leave_type') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Start Date') }}</flux:label>
                    <flux:input type="date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required />
                    @error('start_date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('End Date') }}</flux:label>
                    <flux:input type="date" name="end_date" value="{{ old('end_date', date('Y-m-d')) }}" required />
                    @error('end_date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            </div>

            <flux:field>
                <flux:label>{{ __('Reason') }}</flux:label>
                <flux:textarea name="reason">{{ old('reason') }}</flux:textarea>
                @error('reason') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('leave.index') }}" variant="ghost">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('New Leave Request') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>
@endsection