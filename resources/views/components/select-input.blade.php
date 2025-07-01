@props([
    'name',
    'id' => $name,
    'options' => [],
    'selected' => old($name),
    'placeholder' => '-- Pilih --',
])

<select
    name="{{ $name }}"
    id="{{ $id }}"
    {{ $attributes->merge(['class' => 'block w-full rounded-lg border-green-700 bg-white/30 text-gray-900 focus:ring-green-600 focus:border-green-600 transition shadow-sm backdrop-blur-md']) }}
>
    @if ($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    @foreach($options as $value => $label)
        <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>
