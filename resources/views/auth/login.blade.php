@extends('layouts.auth')

@section('content')
<main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-xl items-center">
    <flux:card class="w-full max-w-md space-y-6">
        <div>
            <flux:heading size="xl" level="1">Let's get started</flux:heading>
            <flux:subheading>Sign in to your account</flux:subheading>
        </div>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
            @csrf
            <x-forms.input label="Username" name="username" type="text" :required="true" />
            <x-forms.input label="Password" name="password" type="password" :required="true" />
            <flux:button type="submit" variant="primary" class="w-full mt-6">Login</flux:button>
        </form>
    </flux:card>
</main>
@endsection