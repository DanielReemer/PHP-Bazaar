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
            <x-text-input id="url" name="url" type="text" class="mt-1 block w-full" :value="old('name', $user->landing_page->url)" />
            <x-input-error :messages="$errors->updateUrl->get('url')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>
