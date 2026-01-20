@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('attendance.index') }}" />
        <flux:heading size="xl" level="1">{{ __('Mark Attendance') }}</flux:heading>
    </div>

    <flux:card>
        <form action="{{ route('attendance.store') }}" method="POST" class="space-y-6">
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
                    <flux:label>{{ __('Date') }}</flux:label>
                    <flux:input type="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required />
                    @error('date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Clock In') }}</flux:label>
                    <flux:input type="time" name="clock_in" value="{{ old('clock_in') }}" />
                    @error('clock_in') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Clock Out') }}</flux:label>
                    <flux:input type="time" name="clock_out" value="{{ old('clock_out') }}" />
                    @error('clock_out') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Status') }}</flux:label>
                    <flux:select name="status" required>
                        <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>{{ __('Present') }}</option>
                        <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>{{ __('Absent') }}</option>
                        <option value="late" {{ old('status') == 'late' ? 'selected' : '' }}>{{ __('Late') }}</option>
                        <option value="on_leave" {{ old('status') == 'on_leave' ? 'selected' : '' }}>{{ __('On Leave') }}</option>
                    </flux:select>
                    @error('status') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            </div>

            <flux:field>
                <flux:label>{{ __('Notes') }}</flux:label>
                <flux:textarea name="notes">{{ old('notes') }}</flux:textarea>
                @error('notes') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('attendance.index') }}" variant="ghost">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('Mark Attendance') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>
@endsection