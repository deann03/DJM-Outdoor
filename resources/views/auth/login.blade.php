@extends('layouts.guest')

@section('title', 'Login')

@section('content')
    {{-- Session Status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email & Nama Pengguna --}}
        <div>
            <x-input-label for="id_user" :value="__('Email atau Nama Pengguna')" />
            <x-text-input id="id_user" class="block mt-1 w-full" type="text" name="id_user" :value="old('id_user')" required autofocus autocomplete="id_user" />
            <x-input-error :messages="$errors->get('id_user')" class="mt-2" />
        </div>

        {{-- Kata Sandi --}}
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   class="block mt-1 w-full bg-white/30 text-gray-900 border-green-700 rounded-lg shadow-sm focus:ring-green-600 focus:border-green-600" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Ingat Saya --}}
        <div class="block mt-4">
            <x-input-label for="remember_me" />
            <x-checkbox-input id="remember_me" name="remember" />
            <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
        </div>

        {{-- Submit + Lupa Kata Sandi --}}
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600"
                   href="{{ route('password.request') }}">
                    Lupa Kata Sandi?
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
@endsection
