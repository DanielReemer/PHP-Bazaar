
<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="mt-16">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-6">
                {{ __('home.recent_adverts') }}
            </h1>
            <div class="grid grid-cols-3 gap-6 lg:gap-8 mt-3">
                @foreach($adverts as $advert)
                    <x-advert-card :advert="$advert"/>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
