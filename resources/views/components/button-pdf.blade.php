@props(['href'])

<a href="{{ $href }}"
   target="_blank"
   class="absolute top-4 right-4 inline-flex items-center gap-2 bg-white/50 text-green-700 text-sm px-3 py-1.5 rounded-3xl shadow hover:bg-yellow-200 hover:text-gray-900 transition">
    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M12 11V3m0 0L8.5 6.5M12 3l3.5 3.5M6 17h12M6 21h12"/>
    </svg>
    Cetak PDF
</a>
