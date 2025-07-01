@props([
    'label',
    'active' => false,
    'align' => 'left',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white/70 text-sm text-gray-800',
])

@php
$triggerClasses = $active
    ? 'inline-flex items-center px-4 py-6 border-b-2 border-green-700 text-sm font-medium leading-5 text-gray-900 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-4 py-6 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-green-700 transition duration-150 ease-in-out';

$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$widthClass = match ($width) {
    '48' => 'w-48',
    default => $width,
};
@endphp

<div class="relative flex items-center" x-data="{ open: false }" @click.outside="open = false">
    {{-- Trigger --}}
    <button @click="open = !open" class="{{ $triggerClasses }}">
        {{ $label }}
        <svg class="w-4 h-4 ml-1 -mt-0.5 transform transition-transform duration-200" :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    {{-- Dropdown --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        class="absolute left-0 top-full mt-0.5 {{ $widthClass }} rounded-md shadow-lg z-50 {{ $alignmentClasses }}"
        style="display: none;"
    >
        <div class="rounded-lg ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $slot }}
        </div>
    </div>
</div>
