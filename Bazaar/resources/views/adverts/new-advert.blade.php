<x-app-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <header  class="mt-6 text-xl font-semibold text-gray-900 dark:text-white w-100 text-center">
            Create New Advert
        </header>
        <div  class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('new-advert') }}" class="flex flex-col gap-5">
                @csrf
                
                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus autocomplete="title" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" :value="__('Description')" />
                    <x-text-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus autocomplete="description" />
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- submit -->
                <div class="flex items-center justify-start mt-4">
                    <x-primary-button class="">
                        {{ __('post') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>