@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <flux:heading size="xl">Users</flux:heading>
    <flux:button variant="primary" href="{{ route('users.create') }}" icon="plus">Create User</flux:button>
</div>

<flux:card padded>
    <flux:table :paginate="$users">
        <flux:table.columns>
            <flux:table.column>Username</flux:table.column>
            <flux:table.column>Role</flux:table.column>
            <flux:table.column>Created At</flux:table.column>
            <flux:table.column align="end">Actions</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach ($users as $user)
            <flux:table.row :key="$user->id">
                <flux:table.cell font="medium">{{ $user->username }}</flux:table.cell>
                <flux:table.cell>
                    <flux:badge size="sm" :color="$user->role === 'admin' ? 'red' : ($user->role === 'staff' ? 'zinc' : 'blue')" inset="top bottom">
                        {{ ucfirst($user->role) }}
                    </flux:badge>
                </flux:table.cell>
                <flux:table.cell class="text-zinc-500 dark:text-zinc-400">{{ $user->created_at->format('M d, Y') }}</flux:table.cell>
                <flux:table.cell align="end">
                    <flux:dropdown>
                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom" />
                        <flux:menu>
                            <flux:menu.item icon="pencil-square" href="{{ route('users.edit', $user) }}">Edit</flux:menu.item>
                            <flux:menu.item icon="trash" variant="danger" x-on:click="$dispatch('open-modal', 'delete-user-{{ $user->id }}')">Delete</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                </flux:table.cell>
            </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</flux:card>

@foreach ($users as $user)
<flux:modal name="delete-user-{{ $user->id }}" class="max-w-md">
    <form method="POST" action="{{ route('users.destroy', $user) }}" class="space-y-6">
        @csrf
        @method('DELETE')

        <div>
            <flux:heading size="lg">Are you sure?</flux:heading>
            <flux:subheading>You're about to delete user <strong>{{ $user->username }}</strong>. This action cannot be undone.</flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:spacer />
            <flux:modal.close>
                <flux:button variant="ghost">Cancel</flux:button>
            </flux:modal.close>
            <flux:button type="submit" variant="danger">Delete User</flux:button>
        </div>
    </form>
</flux:modal>
@endforeach
@endsection