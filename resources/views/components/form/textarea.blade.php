@props(['name'])

<div class="mb-6">
    <x-form.label name="{{ $name }}" />

    <textarea 
        class="border border-gray-200 p-2 w-full rounded"
        name="{{ $name }}"
        id="{{ $name }}"
        rows=5
        required
    >
        {{ $slot ?? old($name) }}
    </textarea>

    <x-form.error name="{{ $name }}" />
</div>