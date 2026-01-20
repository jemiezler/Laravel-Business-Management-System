@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('employees.index') }}" />
        <flux:heading size="xl" level="1">{{ __('Edit Employee') }}: {{ $employee->full_name }}</flux:heading>
    </div>

    <flux:card>
        <form action="{{ route('employees.update', $employee) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>{{ __('Employee ID') }}</flux:label>
                    <flux:input name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}" required />
                    @error('employee_id') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Department') }}</flux:label>
                    <flux:select name="department_id" required>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $employee->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </flux:select>
                    @error('department_id') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('First Name') }}</flux:label>
                    <flux:input name="first_name" value="{{ old('first_name', $employee->first_name) }}" required />
                    @error('first_name') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Last Name') }}</flux:label>
                    <flux:input name="last_name" value="{{ old('last_name', $employee->last_name) }}" required />
                    @error('last_name') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Email Address') }}</flux:label>
                    <flux:input type="email" name="email" value="{{ old('email', $employee->email) }}" required />
                    @error('email') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Phone Number') }}</flux:label>
                    <flux:input name="phone" value="{{ old('phone', $employee->phone) }}" />
                    @error('phone') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Job Title') }}</flux:label>
                    <flux:input name="job_title" value="{{ old('job_title', $employee->job_title) }}" required />
                    @error('job_title') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Status') }}</flux:label>
                    <flux:select name="status" required>
                        <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                        <option value="resigned" {{ old('status', $employee->status) == 'resigned' ? 'selected' : '' }}>{{ __('Resigned') }}</option>
                    </flux:select>
                    @error('status') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            </div>

            <flux:field>
                <flux:label>{{ __('Address') }}</flux:label>
                <flux:textarea name="address">{{ old('address', $employee->address) }}</flux:textarea>
                @error('address') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('employees.index') }}" variant="ghost">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('Update Employee') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>
@endsection