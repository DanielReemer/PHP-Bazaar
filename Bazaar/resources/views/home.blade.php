
<x-app-layout>
    <div class="w-2/3 mx-auto p-6 lg:p-8">
        <div class="mt-16 w-3/4">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-6">
                {{ __('home.recent_adverts') }}
            </h1>

            @livewire('adverts-component', ['data' => $adverts->toJson()])
        </div>
    </div>
</x-app-layout>
