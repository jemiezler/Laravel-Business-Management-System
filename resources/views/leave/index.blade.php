@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <flux:heading size="xl" level="1">{{ __('Leave') }}</flux:heading>
        <flux:button href="{{ route('leave.create') }}" variant="primary" icon="plus">{{ __('New Leave Request') }}</flux:button>
    </div>

    @if (session('status'))
    <flux:text color="green" class="mb-4">{{ __(session('status')) }}</flux:text>
    @endif

    <flux:card>
        <flux:table :paginate="$leave_requests">
            <flux:table.columns>
                <flux:table.column>{{ __('Employee') }}</flux:table.column>
                <flux:table.column>{{ __('Leave Type') }}</flux:table.column>
                <flux:table.column>{{ __('Start Date') }}</flux:table.column>
                <flux:table.column>{{ __('End Date') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
                <flux:table.column>{{ __('Actions') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($leave_requests as $request)
                <flux:table.row :key="$request->id">
                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:avatar initials="{{ substr($request->employee->first_name, 0, 1) . substr($request->employee->last_name, 0, 1) }}" size="xs" />
                            <flux:text weight="medium">{{ $request->employee->full_name }}</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>{{ __(ucfirst($request->leave_type)) }}</flux:table.cell>
                    <flux:table.cell>{{ $request->start_date->format('Y-m-d') }}</flux:table.cell>
                    <flux:table.cell>{{ $request->end_date->format('Y-m-d') }}</flux:table.cell>
                    <flux:table.cell>
                        @php
                        $color = match($request->status) {
                        'approved' => 'green',
                        'rejected' => 'red',
                        'pending' => 'orange',
                        default => 'zinc'
                        };
                        @endphp
                        <flux:badge :color="$color">
                            {{ __(ucfirst($request->status)) }}
                        </flux:badge>
                    </flux:table.cell>
                    <flux:table.cell>
                        @if($request->status === 'pending')
                        <div class="flex gap-2">
                            <form action="{{ route('leave.approve', $request) }}" method="POST">
                                @csrf
                                <flux:button size="sm" variant="ghost" color="green" type="submit">{{ __('Approve') }}</flux:button>
                            </form>
                            <form action="{{ route('leave.reject', $request) }}" method="POST">
                                @csrf
                                <flux:button size="sm" variant="ghost" color="red" type="submit">{{ __('Reject') }}</flux:button>
                            </form>
                        </div>
                        @else
                        <flux:text size="sm" color="zinc">
                            {{ __('Processed') }}
                        </flux:text>
                        @endif
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="6" class="text-center py-4">
                        <flux:text color="zinc">{{ __('No leave requests found.') }}</flux:text>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
@endsection