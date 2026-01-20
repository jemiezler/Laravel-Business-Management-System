@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('employees.index') }}" />
        <flux:heading size="xl" level="1">{{ __('Add New Employee') }}</flux:heading>
    </div>

    <flux:card>
        <form action="{{ route('employees.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:field>
                    <flux:label>{{ __('Employee ID') }}</flux:label>
                    <flux:input name="employee_id" placeholder="EMP001" value="{{ old('employee_id') }}" required />
                    @error('employee_id') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Department') }}</flux:label>
                    <flux:select name="department_id" :placeholder="__('Select department...')" required>
                        @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </flux:select>
                    @error('department_id') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('First Name') }}</flux:label>
                    <flux:input name="first_name" value="{{ old('first_name') }}" required />
                    @error('first_name') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Last Name') }}</flux:label>
                    <flux:input name="last_name" value="{{ old('last_name') }}" required />
                    @error('last_name') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Email Address') }}</flux:label>
                    <flux:input type="email" name="email" value="{{ old('email') }}" required />
                    @error('email') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Phone Number') }}</flux:label>
                    <flux:input name="phone" value="{{ old('phone') }}" />
                    @error('phone') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Job Title') }}</flux:label>
                    <flux:input name="job_title" value="{{ old('job_title') }}" required />
                    @error('job_title') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Hire Date') }}</flux:label>
                    <flux:input type="date" name="hire_date" value="{{ old('hire_date', date('Y-m-d')) }}" required />
                    @error('hire_date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Monthly Salary') }}</flux:label>
                    <flux:input type="number" step="0.01" name="salary" value="{{ old('salary', 0) }}" required />
                    @error('salary') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            </div>

            <flux:field>
                <flux:label>{{ __('Address') }}</flux:label>
                <flux:textarea name="address">{{ old('address') }}</flux:textarea>
                @error('address') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('employees.index') }}" variant="ghost">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('Create Employee') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>
@endsection