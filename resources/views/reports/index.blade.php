@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <flux:heading size="xl" level="1">{{ __('Reports') }}</flux:heading>
        <flux:button icon="printer" variant="ghost" onclick="window.print()">{{ __('Print Report') }}</flux:button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Attendance Trends -->
        <flux:card>
            <flux:heading size="lg" class="mb-4">{{ __('Attendance Trends (Last 7 Days)') }}</flux:heading>
            <div class="space-y-4">
                @foreach($attendance_summary as $summary)
                <div class="flex items-center gap-4">
                    <div class="w-24 text-sm text-zinc-500">{{ Carbon\Carbon::parse($summary->date)->format('D, M d') }}</div>
                    <div class="flex-1 flex h-4 rounded-full overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                        <div class="bg-emerald-500" style=`width: {{ ($summary->present / ($summary->present + $summary->absent + $summary->late ?: 1)) * 100 }}%`></div>
                        <div class="bg-amber-400" style=`width: {{ ($summary->late / ($summary->present + $summary->absent + $summary->late ?: 1)) * 100 }}%`></div>
                        <div class="bg-rose-500" style=`width: {{ ($summary->absent / ($summary->present + $summary->absent + $summary->late ?: 1)) * 100 }}%`></div>
                    </div>
                </div>
                @endforeach
                <div class="flex justify-center gap-4 text-xs mt-4">
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-emerald-500"></div> Present
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-amber-400"></div> Late
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-2 h-2 rounded-full bg-rose-500"></div> Absent
                    </div>
                </div>
            </div>
        </flux:card>

        <!-- Payroll Summary -->
        <flux:card>
            <flux:heading size="lg" class="mb-4">{{ __('Payroll Expenditure') }}</flux:heading>
            <div class="space-y-4">
                @foreach($payroll_summary as $payroll)
                <div class="flex justify-between items-center py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <span class="text-zinc-600 dark:text-zinc-400">{{ $payroll->month }}</span>
                    <span class="font-semibold">฿{{ number_format($payroll->total_cost, 2) }}</span>
                </div>
                @endforeach
            </div>
        </flux:card>

        <!-- Department Distribution -->
        <flux:card class="md:col-span-2">
            <flux:heading size="lg" class="mb-4">{{ __('Department Breakdown') }}</flux:heading>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-800">
                            <th class="py-3 px-4 font-semibold text-zinc-500">{{ __('Department') }}</th>
                            <th class="py-3 px-4 font-semibold text-zinc-500">{{ __('Employee Count') }}</th>
                            <th class="py-3 px-4 font-semibold text-zinc-500">{{ __('Average Salary') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($department_stats as $stat)
                        <tr class="border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                            <td class="py-3 px-4">{{ $stat->name }}</td>
                            <td class="py-3 px-4">{{ $stat->count }}</td>
                            <td class="py-3 px-4">฿{{ number_format($stat->avg_salary, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </flux:card>

        <!-- Performance Distribution -->
        <flux:card>
            <flux:heading size="lg" class="mb-4">{{ __('Performance Rating Distribution') }}</flux:heading>
            <div class="space-y-3">
                @foreach($performance_summary as $perf)
                <div class="flex items-center gap-3">
                    <div class="flex gap-0.5 w-24">
                        @for($i = 0; $i
                        < 5; $i++)
                            <flux:icon name="star" variant="{{ $i < $perf->rating ? 'solid' : 'outline' }}" class="w-3 h-3 {{ $i < $perf->rating ? 'text-amber-400' : 'text-zinc-300' }}" />
                        @endfor
                    </div>
                    <div class="flex-1 bg-zinc-100 dark:bg-zinc-800 rounded-full h-2">
                        <div class="bg-indigo-500 h-2 rounded-full" style=`width: {{ ($perf->count / $performance_summary->sum('count')) * 100 }}%`></div>
                    </div>
                    <div class="text-sm font-medium w-8 text-right">{{ $perf->count }}</div>
                </div>
                @endforeach
            </div>
        </flux:card>

        <!-- Leave Distribution -->
        <flux:card>
            <flux:heading size="lg" class="mb-4">{{ __('Leave Types (Approved)') }}</flux:heading>
            <div class="space-y-4">
                @foreach($leave_summary as $leave)
                <div class="flex justify-between items-center py-2 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <span class="capitalize text-zinc-600 dark:text-zinc-400">{{ $leave->leave_type }}</span>
                    <span class="font-semibold">{{ $leave->count }} {{ __('Requests') }}</span>
                </div>
                @endforeach
            </div>
        </flux:card>
    </div>
</div>
@endsection