<x-app-layout>
    <div class="w-2/3 mx-auto p-6 lg:p-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-6">
            {{ __('favorite.my_favorite_adverts') }}
        </h1>
        <div class="p-5 w-1/2">
            @if(count($data['favorites']) <= 0)
                <p class="mt-3 text-gray-600 dark:text-gray-400">
                    {{ __('favorite.no_favorite') }}
                </p>
            @else
                @foreach ($data['favorites'] as $favorite)
                    <x-advert-card :advert="$favorite->advert"></x-advert-card>
                @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
