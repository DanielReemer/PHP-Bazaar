<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('registration.Roles') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __($role->translation_key) }}
        </p>

        @if ($user->api_key)
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('api.yourkeymessage') }}
                <span>{{ $user->api_key }}</span>
            </p>
        @endif
    </header>
</section>
