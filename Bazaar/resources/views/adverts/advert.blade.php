<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8 flex gap-20">
        <div class="flex-1">
            <div class="flex">
                <form method="POST" action="{{ route('favoriteAdvert.update', ['id' => $data['advert']->id]) }}">
                    @csrf
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-6">
                        {{ $data['advert']->title }}
                        @if(auth()->user())
                            <button type="submit">
                                <span class="text-yellow-300 text-gray-300"></span> <!-- Render classes -->

                                <svg class="w-6 h-6 text-{{ $data['favorited'] }}-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                            </button>
                        @endif
                    </h1>
                </form>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-500">
                {{ __('advert.since') }} {{ $data['advert']->created_at }}
            </p>
            <p class="mt-4 text-base text-gray-600 dark:text-gray-400">
                {{ $data['advert']->description }}
            </p>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mt-6">
                {{ __('advert.reviews') }}
            </h2>

            @if(auth()->user())
                <form method="POST" action="{{ route('advertReview.store', ['id' => $data['advert']->id]) }}">
                    @csrf
                    <div class="flex mt-3 mb-3 gap-5">
                        <div class="basis-5/6">
                            <label for="title" class="font-bold text-base text-gray-600 dark:text-gray-400">{{ __('advert.title') }}</label><br>
                            <input type="text" id="title" name="title" required class="w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:border-gray-600">
                        </div>

                        <div class="basis-1/6">
                            <label for="rating" class="font-bold text-base text-gray-600 dark:text-gray-400">{{ __('advert.rating') }}</label>
                            <input type="number" id="rating" name="rating" max="5" min="0" required class="w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:border-gray-600">
                        </div>
                    </div>
                    <label for="review" class="font-bold text-base text-gray-600 dark:text-gray-400">{{ __('advert.review') }}</label><br>
                    <textarea id="review" name="review" rows="5" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"></textarea>
                    <button type="submit" class="mt-6 bg-transparent hover:bg-gray-800 text-gray-200 font-semibold hover:text-gray-200 py-2 px-4 border border-gray-200 hover:border-transparent rounded">{{ __('advert.submit_review') }}</button>
                </form>
            @else
                <p class="mt-2 text-base text-gray-800 dark:text-gray-200 font-bold">
                    {{ __('advert.login_to_comment') }}
                </p>
            @endif

            <div class="mt-10">
                @if(count($data['reviews']) <= 0)
                    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                        {{ __('advert.no_reviews') }}
                    </p>
                @else
                    @foreach ($data['reviews'] as $review)
                        <x-advert-review :review="$review"></x-advert-review>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="flex-1">
            <div class="w-1/2 p-5">
                <div class="flex justify-center">
                    {{ $data['qrcode'] }}
                </div>
                <hr class="mt-5 mb-5">
                <div class="m-5">
                    <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ __('advert.advert_by') }}</p>
                    <p class="text-base text-gray-700 dark:text-gray-300">
                        <a href="{{ route('profile.show', ['id' => $data['advert']->owner->id]) }}">{{ $data['advert']->owner->name }}</a>
                    </p>
                    {{-- Add buttons like hire or something here --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
