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
            <flux:navlist.item icon="home" href="{{ route('home') }}" :current="request()->is('/')">Dashboard</flux:navlist.item>
            <flux:navlist.item icon="users" href="{{ route('employees.index') }}" :current="request()->is('employees*')">Employees</flux:navlist.item>
            <flux:navlist.item icon="calendar" href="#">Attendance</flux:navlist.item>
            <flux:navlist.item icon="document-text" href="#">Leave</flux:navlist.item>
            <flux:navlist.item icon="credit-card" href="#">Payroll</flux:navlist.item>
            <flux:navlist.item icon="presentation-chart-line" href="#">Performance</flux:navlist.item>
            <flux:navlist.item icon="chart-bar" href="#">Reports</flux:navlist.item>
        </flux:navlist>

        <flux:spacer />

        <flux:navlist variant="outline">
            <flux:navlist.item icon="user-group" href="{{ route('users.index') }}" :current="request()->is('users*')">Settings</flux:navlist.item>
        </flux:navlist>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:profile avatar="https://testingbot.com/free-online-tools/random-avatar/300" :name="auth()->user()?->username ?? 'Guest'" />

            <flux:menu>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:menu.item icon="x-circle" as="button" type="submit">Logout</flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown align="end">
            <flux:profile avatar="https://fluxui.dev/img/demo/avatar.png" />

            <flux:menu>
                <flux:menu.item icon="x-circle">Logout</flux:menu.item>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    <flux:main>
        @yield('content')
    </flux:main>

    @fluxScripts
</body>

</html>