<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'px-4 py-2 bg-white/50 text-green-700 font-medium rounded-3xl shadow hover:bg-yellow-200 hover:text-gray-900 transition duration-150'
]) }}>
    {{ $slot }}
</button>
