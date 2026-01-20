@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-2">
        <flux:button variant="ghost" icon="arrow-left" href="{{ route('performance.index') }}" />
        <flux:heading size="xl" level="1">{{ __('New Performance Review') }}</flux:heading>
    </div>

    <flux:card>
        <form action="{{ route('performance.store') }}" method="POST" class="space-y-6">
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
                    <flux:label>{{ __('Reviewer') }}</flux:label>
                    <flux:input name="reviewer_name" value="{{ auth()->user()->username ?? auth()->user()->name }}" readonly class="bg-zinc-50 dark:bg-zinc-800" />
                    <input type="hidden" name="reviewer_id" value="{{ auth()->id() }}">
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Review Date') }}</flux:label>
                    <flux:input type="date" name="review_date" value="{{ old('review_date', date('Y-m-d')) }}" required />
                    @error('review_date') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Score') }} (1-5)</flux:label>
                    <flux:select name="score" required>
                        <option value="1">1 - Poor</option>
                        <option value="2">2 - Fair</option>
                        <option value="3" selected>3 - Good</option>
                        <option value="4">4 - Very Good</option>
                        <option value="5">5 - Excellent</option>
                    </flux:select>
                    @error('score') <flux:error>{{ $message }}</flux:error> @enderror
                </flux:field>
            </div>

            <flux:field>
                <flux:label>{{ __('Comments') }}</flux:label>
                <flux:textarea name="comments">{{ old('comments') }}</flux:textarea>
                @error('comments') <flux:error>{{ $message }}</flux:error> @enderror
            </flux:field>

            <div class="flex justify-end gap-3">
                <flux:button href="{{ route('performance.index') }}" variant="ghost">{{ __('Cancel') }}</flux:button>
                <flux:button type="submit" variant="primary">{{ __('New Performance Review') }}</flux:button>
            </div>
        </form>
    </flux:card>
</div>
@endsection