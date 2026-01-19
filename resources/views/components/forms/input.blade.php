@props([
'label',
'description' => null,
'type' => 'text',
'name',
'required' => false,
])

<div class="mb-2">
    <flux:field>
        <flux:label>{{ $label }}</flux:label>
        @if($description)
        <flux:description>{{ $description }}</flux:description>
        @endif
        <flux:input name="{{ $name }}" type="{{ $type }}" />
        <flux:error name="{{ $name }}" />
    </flux:field>
</div>