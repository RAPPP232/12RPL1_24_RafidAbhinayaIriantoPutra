<x-guest-layout>

    <!-- Container utama responsif -->
    <div class="max-w-md w-full mx-auto sm:px-6 lg:px-8">

        <!-- Header dengan gradien teks -->
        <div class="text-center mb-8">
            <h2
                class="text-2xl sm:text-3xl font-extrabold bg-gradient-to-r from-white to-blue-100 bg-clip-text text-transparent drop-shadow-sm mb-2">
                Sistem Pencatatan Pemotongan
            </h2>
            <p class="text-white/90 text-xs sm:text-sm font-medium">
                Silahkan login untuk melanjutkan
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status
            class="mb-4 text-white bg-green-500/30 px-3 py-2 rounded-lg"
            :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-5">
                <x-input-label for="email" :value="__('Email')" class="text-white font-medium mb-2" />
                <div class="relative">
                    <x-text-input id="email"
                        class="block w-full rounded-xl truncate border-white/30 bg-white/15 text-white placeholder-white/70 
                                focus:border-white focus:ring-0 input-glow py-3 px-4 transition-all duration-200"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
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

            <!-- Password -->
            <div class="mb-5">
                <x-input-label for="password" :value="__('Password')" class="text-white font-medium mb-2" />
                <div class="relative">
                    <x-text-input id="password"
                        class="block w-full rounded-xl border-white/30 bg-white/15 text-white placeholder-white/70 
                                focus:border-white focus:ring-0 input-glow py-3 px-4 transition-all duration-200"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="********" />

                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="h-5 w-5 text-white/60" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-200 bg-red-500/20 px-3 py-1 rounded-lg" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mb-6">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <div class="relative">
                        <input id="remember_me" type="checkbox" class="sr-only" name="remember">
                        <div class="w-4 h-4 bg-white/20 rounded border border-white/40 flex items-center justify-center">
                            <svg class="w-3 h-3 text-white hidden check-icon" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <span class="ms-2 text-sm text-white/90 select-none">Remember me</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8">

                @if (Route::has('password.request'))
                    <a class="text-sm text-white/80 hover:text-white underline transition-colors duration-200"
                        href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif

                <x-primary-button class="px-6 py-3 rounded-xl btn-primary text-white font-bold shadow-lg w-full sm:w-auto flex items-center justify-center">
                    {{ __('Log in') }}
                    <svg class="w-4 h-4 ml-2 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </x-primary-button>
            </div>

        </form>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rememberCheckbox = document.getElementById('remember_me');
            const checkIcon = document.querySelector('.check-icon');

            rememberCheckbox.addEventListener('change', function() {
                checkIcon.classList.toggle('hidden', !this.checked);
            });

            if (rememberCheckbox.checked) {
                checkIcon.classList.remove('hidden');
            }
        });
    </script>

</x-guest-layout>
