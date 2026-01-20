@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <flux:heading size="xl" level="1">{{ __('Attendance') }}</flux:heading>
        <flux:button href="{{ route('attendance.create') }}" variant="primary" icon="plus">{{ __('Mark Attendance') }}</flux:button>
    </div>

    @if (session('status'))
    <flux:text color="green" class="mb-4">{{ __(session('status')) }}</flux:text>
    @endif

    <flux:card>
        <flux:table :paginate="$attendance">
            <flux:table.columns>
                <flux:table.column>{{ __('Employee') }}</flux:table.column>
                <flux:table.column>{{ __('Date') }}</flux:table.column>
                <flux:table.column>{{ __('Clock In') }}</flux:table.column>
                <flux:table.column>{{ __('Clock Out') }}</flux:table.column>
                <flux:table.column>{{ __('Status') }}</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @forelse($attendance as $record)
                <flux:table.row :key="$record->id">
                    <flux:table.cell>
                        <div class="flex items-center gap-2">
                            <flux:avatar initials="{{ substr($record->employee->first_name, 0, 1) . substr($record->employee->last_name, 0, 1) }}" size="xs" />
                            <flux:text weight="medium">{{ $record->employee->full_name }}</flux:text>
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>{{ $record->date->format('Y-m-d') }}</flux:table.cell>
                    <flux:table.cell>{{ $record->clock_in ?? '-' }}</flux:table.cell>
                    <flux:table.cell>{{ $record->clock_out ?? '-' }}</flux:table.cell>
                    <flux:table.cell>
                        @php
                        $color = match($record->status) {
                        'present' => 'green',
                        'absent' => 'red',
                        'late' => 'orange',
                        'on_leave' => 'blue',
                        default => 'zinc'
                        };
                        @endphp
                        <flux:badge :color="$color">
                            {{ __(ucfirst($record->status)) }}
                        </flux:badge>
                    </flux:table.cell>
                </flux:table.row>
                @empty
                <flux:table.row>
                    <flux:table.cell colspan="5" class="text-center py-4">
                        <flux:text color="zinc">{{ __('No attendance records found.') }}</flux:text>
                    </flux:table.cell>
                </flux:table.row>
                @endforelse
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
@endsection