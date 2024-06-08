<x-app-layout>
    <div class="flex w-full justify-center mt-10 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div
            class="sm:max-w-md w-1/4 mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg h-fit">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <header class="mt-6 text-xl font-semibold text-gray-900 dark:text-white w-100 text-center">
                {{ __('login.login') }}
            </header>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('auth.email_field')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('auth.password_field')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                               name="remember">
                        <span
                            class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('auth.remember_checkbox') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                       href="{{ route('register') }}">
                        {{ __('Not yet registered?') }}
                    </a>

                    <x-primary-button class="ms-3">
                        {{ __('auth.login_button') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
