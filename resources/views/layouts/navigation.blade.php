<nav 
    x-data="{ open: false, lastScroll: 0, hidden: false }"
        x-init="window.addEventListener('scroll', () => {
            let curr = window.scrollY;
            hidden = curr > lastScroll && curr > 100;
            lastScroll = curr;
        })"
        :class="{ '-translate-y-full': hidden }"
        class="sticky top-0 z-50 bg-white/70 border-b border-transparent backdrop-blur-md transition-transform duration-300"
    >
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Beranda') }}
                    </x-nav-link>

                    @if (Auth::user()->role === 'admin')
                    <x-nav-link :href="route('admin.barang.index')" :active="request()->routeIs('barang.index')">
                        {{ __('Kelola Barang') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.paket.index')" :active="request()->routeIs('paket.index')">
                        {{ __('Kelola Paket') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.penyewaan.index')" :active="request()->routeIs('admin.penyewaan.index')">
                        {{ __('Kelola Penyewaan') }}
                    </x-nav-link>
                    @endif

                    @if (Auth::user()->role === 'user')
                    <x-nav-dropdown label="Informasi" :active="request()->routeIs('user.informasi.*')">
                        <x-dropdown-link :href="route('user.informasi.tentang')" @click="open = false">
                            {{ __('Tentang') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('user.informasi.kontak')" @click="open = false">
                            {{ __('Kontak') }}
                        </x-dropdown-link>
                    </x-nav-dropdown>
                    
                    <x-nav-link :href="route('user.katalog.index')" :active="request()->routeIs('user.katalog.index')">
                        {{ __('Produk') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user.keranjang.index')" :active="request()->routeIs('user.keranjang.index')">
                        {{ __('Keranjang') }}
                    </x-nav-link>

                    <x-nav-link :href="route('user.penyewaan.index')" :active="request()->routeIs('user.penyewaan.index')">
                        {{ __('Penyewaan') }}
                    </x-nav-link>
                    @endif
                </div>                
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-gray-500 bg-white/30 shadow-sm hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Beranda') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('admin.barang.index')" :active="request()->routeIs('barang.index')">
                {{ __('Kelola Barang') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.paket.index')" :active="request()->routeIs('paket.index')">
                {{ __('Kelola Paket') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.penyewaan.index')" :active="request()->routeIs('paket.index')">
                {{ __('Kelola Penyewaan') }}
            </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'user')
            <div x-data="{ openInfo: false }">
                <button @click="openInfo = !openInfo"
                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300 transition duration-150 ease-in-out">
                    Informasi
                    <svg class="inline w-4 h-4 ml-1 transform" :class="openInfo ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="openInfo" class="pl-6 mt-1 space-y-1">
                    <x-responsive-nav-link :href="route('user.informasi.tentang')">
                        Tentang
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user.informasi.kontak')">
                        Kontak
                    </x-responsive-nav-link>
                </div>
            </div>

            <x-responsive-nav-link :href="route('user.katalog.index')" :active="request()->routeIs('katalog.index')">
                {{ __('Produk') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('user.keranjang.index')" :active="request()->routeIs('keranjang.index')">
                {{ __('Keranjang') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('user.penyewaan.index')" :active="request()->routeIs('penyewaan.index')">
                {{ __('Penyewaan') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
