@props(['id', 'name'])

<input id="{{ $id }}" name="{{ $name }}" type="checkbox"
    {{ $attributes->merge(['class' => 'rounded border-green-700 text-green-600 shadow-sm focus:ring-green-600']) }}>
