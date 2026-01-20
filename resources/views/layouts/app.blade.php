<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body class="min-h-screen bg-white font-sans antialiased dark:bg-zinc-900">
    <flux:sidebar sticky stashable class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-800">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <flux:brand href="/" logo="https://fluxui.dev/img/demo/logo.png" name="BMS Admin" class="px-2 dark:hidden" />
        <flux:brand href="/" logo="https://fluxui.dev/img/demo/favicon.png" name="BMS Admin" class="px-2 hidden dark:flex" />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="home" href="{{ route('home') }}" :current="request()->is('/')">{{ __('Dashboard') }}</flux:navlist.item>
            <flux:navlist.item icon="users" href="{{ route('employees.index') }}" :current="request()->is('employees*')">{{ __('Employees') }}</flux:navlist.item>
            <flux:navlist.item icon="calendar" href="{{ route('attendance.index') }}" :current="request()->is('attendance*')">{{ __('Attendance') }}</flux:navlist.item>
            <flux:navlist.item icon="document-text" href="{{ route('leave.index') }}" :current="request()->is('leave*')">{{ __('Leave') }}</flux:navlist.item>
            <flux:navlist.item icon="credit-card" href="{{ route('payroll.index') }}" :current="request()->is('payroll*')">{{ __('Payroll') }}</flux:navlist.item>
            <flux:navlist.item icon="presentation-chart-line" href="{{ route('performance.index') }}" :current="request()->is('performance*')">{{ __('Performance') }}</flux:navlist.item>
            <flux:navlist.item icon="chart-bar" href="#">{{ __('Reports') }}</flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="user-group" href="{{ route('users.index') }}" :current="request()->is('users*')">{{ __('Settings') }}</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile avatar="https://testingbot.com/free-online-tools/random-avatar/300" :name="auth()->user()?->username ?? 'Guest'" />

            <flux:menu class="min-w-48">
                <flux:menu.group x-data class="border-zinc-200 dark:border-zinc-800">
                    <flux:heading size="sm" class="px-2 text-zinc-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">{{ __('Language') }}</flux:heading>
                    <flux:menu.item icon="language" :current="app()->getLocale() === 'en'" href="{{ route('locale.switch', 'en') }}">English</flux:menu.item>
                    <flux:menu.item icon="language" :current="app()->getLocale() === 'th'" href="{{ route('locale.switch', 'th') }}">ไทย</flux:menu.item>
                </flux:menu.group>

                <flux:menu.group x-data class="border-zinc-200 dark:border-zinc-800">
                    <flux:heading size="sm" class="px-2 text-zinc-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">{{ __('Theme') }}</flux:heading>
                    <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">{{ __('Light') }}</flux:menu.item>
                    <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">{{ __('Dark') }}</flux:menu.item>
                    <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">{{ __('System') }}</flux:menu.item>
                </flux:menu.group>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item icon="x-circle" as="button" type="submit">{{ __('Logout') }}</flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown align="end">
            <flux:profile avatar="https://fluxui.dev/img/demo/avatar.png" />

            <flux:menu class="min-w-48">
                <flux:menu.group x-data class="border-zinc-200 dark:border-zinc-800">
                    <flux:heading size="sm" class="px-2 text-zinc-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">{{ __('Language') }}</flux:heading>
                    <flux:menu.item icon="language" :current="app()->getLocale() === 'en'" href="{{ route('locale.switch', 'en') }}">English</flux:menu.item>
                    <flux:menu.item icon="language" :current="app()->getLocale() === 'th'" href="{{ route('locale.switch', 'th') }}">ไทย</flux:menu.item>
                </flux:menu.group>

                <flux:menu.group x-data class="border-zinc-200 dark:border-zinc-800">
                    <flux:heading size="sm" class="px-2 text-zinc-400 dark:text-zinc-500 uppercase tracking-wider font-semibold">{{ __('Theme') }}</flux:heading>
                    <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">{{ __('Light') }}</flux:menu.item>
                    <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">{{ __('Dark') }}</flux:menu.item>
                    <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">{{ __('System') }}</flux:menu.item>
                </flux:menu.group>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item icon="x-circle" as="button" type="submit">{{ __('Logout') }}</flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:main>
        @yield('content')
    </flux:main>

    @fluxScripts
</body>

</html>