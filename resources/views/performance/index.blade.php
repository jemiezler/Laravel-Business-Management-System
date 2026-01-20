@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <flux:heading size="xl" level="1">{{ __('Performance') }}</flux:heading>
        <flux:button href="{{ route('performance.create') }}" variant="primary" icon="plus">{{ __('New Review') }}</flux:button>
    </div>

    @if (session('status'))
    <flux:text color="green" class="mb-4">{{ __(session('status')) }}</flux:text>
    @endif

    <flux:card>
        <flux:table :paginate="$reviews">
            <flux:table.columns>
                <flux:table.column>{{ __('Employee') }}</flux:table.column>
                <flux:table.column>{{ __('Review Date') }}</flux:table.column>
                <flux:table.column>{{ __('Score') }}</flux:table.column>
                <flux:table.column>{{ __('Reviewer') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($reviews as $review)
                <flux:table.row :key="$review->id">
                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:avatar initials="{{ substr($review->employee->first_name, 0, 1) . substr($review->employee->last_name, 0, 1) }}" size="xs" />
                            <flux:text weight="medium">{{ $review->employee->full_name }}</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>{{ $review->review_date->format('Y-m-d') }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="flex items-center gap-1">
                            <flux:text weight="semibold">{{ $review->score }}</flux:text>
                            <flux:text color="zinc">/ 5</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>{{ $review->reviewer->username ?? $review->reviewer->name ?? 'N/A' }}</flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="4" class="text-center py-4">
                        <flux:text color="zinc">{{ __('No performance reviews found.') }}</flux:text>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
@endsection