@extends('layouts.app')

@section('content')
    <div class="bg-gray-300 mx-auto h-full flex justify-center items-center">
        <div class="w-96 p-6 rounded-lg bg-blue-900 shadow-xl">
            <div class="text-white text-3xl">The Book Store</div>
            <h1 class="text-white text-2xl pt-8">Join Us</h1>
            <h2 class="text-base text-blue-300">Enter your information below</h2>

            <form method="POST" action="{{ route('register') }}" class="pt-8">
                @csrf

                <div class="relative">
                    <label for="name" class="text-blue-500 text-xs font-bold pl-3 pt-2 absolute uppercase">Full Name</label>

                    <input id="name" type="text" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-blue-700 bg-blue-800 text-gray-100 @error('name') border border-red-600 @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Your Name">

                    @error('name')
                    <span class="text-red-600 text-xs" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="relative pt-3">
                    <label for="email" class="text-blue-500 text-xs font-bold pl-3 pt-2 absolute uppercase">E-Mail</label>

                    <input id="email" type="email" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-blue-700 bg-blue-800 text-gray-100 @error('email') border border-red-600 @enderror" name="email" value="{{ old('email') }}" autocomplete="email" autofocus placeholder="your@email.com">

                    @error('email')
                    <span class="text-red-600 text-xs" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="relative pt-3">
                    <label for="password" class="text-blue-500 text-xs font-bold pl-3 pt-2 absolute uppercase">Password</label>

                    <input id="password" type="password" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-blue-700 bg-blue-800 text-gray-100 @error('password') border border-red-600 @enderror" name="password" autocomplete="current-password" placeholder="Password">

                    @error('password')
                    <span class="text-red-600 text-xs" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="relative pt-3">
                    <label for="password-confirm" class="text-blue-500 text-xs font-bold pl-3 pt-2 absolute uppercase">Re-enter Password</label>

                    <input id="password-confirm" type="password" class="w-full p-3 pt-8 rounded focus:outline-none focus:bg-blue-700 bg-blue-800 text-gray-100" name="password_confirmation" placeholder="Confirm">
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full rounded py-2 px-3 uppercase text-left bg-gray-400 text-blue-800 text-gray-100 font-bold">Register</button>
                </div>

                <div class="pt-8 flex justify-between text-white text-sm font-bold">
{{--                    <a class="hover:text-blue-200" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>--}}
                    <a class="hover:text-blue-200" href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
@endsection