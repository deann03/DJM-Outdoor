@props(['title', 'value', 'color' => 'text-gray-900'])

<div class="bg-white/70 backdrop-blur-md p-6 rounded-xl shadow-md">
    <h3 class="text-sm font-medium text-gray-600">{{ $title }}</h3>
    <p class="text-2xl font-bold {{ $color }}">{{ $value }}</p>
</div>