<x-guest-layout>
    <div class="mb-6 text-sm text-white text-justify">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" :value="__('Email')" class="text-white font-medium mb-2" />
            <div class="relative">
                <x-text-input id="email"
                    class="block w-full rounded-xl border-white/30 bg-white/15 text-white placeholder-white/70 
                            focus:border-white focus:ring-0 input-glow py-3 px-4 transition-all duration-200"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="email"
                    placeholder="jono@example.com" />

                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="h-5 w-5 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-200 bg-red-500/20 px-3 py-1 rounded-lg" />
        </div>

        <!-- Buttons -->
        <div class="flex flex-row items-center justify-center gap-4 mt-4">
            <x-primary-button class="px-6 py-3 rounded-xl btn-primary text-white font-bold shadow-lg w-full sm:w-auto flex items-center justify-center">
                {{ __('Email Password Reset Link') }}
                <svg class="w-4 h-4 ml-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
