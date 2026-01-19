@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <flux:heading size="xl">{{ isset($user->id) ? 'Edit User' : 'Create User' }}</flux:heading>
        <flux:subheading>Manage system access and roles.</flux:subheading>
    </div>

    <flux:card padded>
        <form method="POST" action="{{ isset($user->id) ? route('users.update', $user) : route('users.store') }}" class="space-y-6">
            @csrf
            @if(isset($user->id))
            @method('PUT')
            @endif

            <flux:field>
                <flux:label>Username</flux:label>
                <flux:input name="username" :value="old('username', $user->username)" required autofocus />
                <flux:error name="username" />
            </flux:field>

            <flux:field>
                <flux:label>Role</flux:label>
                <flux:select name="role">
                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="viewer" {{ old('role', $user->role) === 'viewer' ? 'selected' : '' }}>Viewer</option>
                </flux:select>
                <flux:error name="role" />
            </flux:field>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <flux:field>
                    <flux:label>Password {{ isset($user->id) ? '(Leave blank to keep current)' : '' }}</flux:label>
                    <flux:input type="password" name="password" {{ isset($user->id) ? '' : 'required' }} />
                    <flux:error name="password" />
                </flux:field>

                <flux:field>
                    <flux:label>Confirm Password</flux:label>
                    <flux:input type="password" name="password_confirmation" {{ isset($user->id) ? '' : 'required' }} />
                    <flux:error name="password_confirmation" />
                </flux:field>
            </div>

            <div class="flex gap-2">
                <flux:spacer />
                <flux:button href="{{ route('users.index') }}" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">
                    {{ isset($user->id) ? 'Update User' : 'Create User' }}
                </flux:button>
            </div>
        </form>
    </flux:card>
</div>
@endsection