<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.custom_url') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.custom_url_desc') }}
        </p>
    </header>

    <form method="post" action="{{ route('url.update') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="url" :value="__('profile.url')" />
            <div class="flex items-center mt-1">
                <p class="text-lg text-gray-600 dark:text-gray-400">page/</p>
                <x-text-input id="url" name="url" type="text" class="block w-full ml-2" :value="old('name', $user->landing_page->url)" />
            </div>
            <x-input-error :messages="$errors->updateUrl->get('url')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>
        </div>
    </form>
</section>
