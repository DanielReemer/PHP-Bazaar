<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8 gap-20">
        <div class="flex mt-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $user->name }}
            </h1>

            @if($user->role_id === 3 && $user->landing_page->url !== null)
                <div class="self-center p-1 ml-5 size-fit justify-self-end bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 border border-gray-300 hover:border-transparent rounded">
                    <a href="{{ route('page', ["slug" => $user->landing_page->url]) }}" target="_blank">{{ __('public-profile.business_page') }}</a>
                </div>
            @endif
        </div>
        <hr class="text-gray-600 dark:text-gray-400 w-full mt-2">

        <div class="flex flex-row gap-10 mt-5">
            <div class="w-3/4">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 m-3">{{ __('public-profile.adverts') }}</h2>
                <div class="w-3/4">
                    @foreach($adverts as $advert)
                        <div class="mt-5">
                            <x-advert-card :advert="$advert"/>
                        </div>
                    @endforeach
                </div>
            </div>
            <aside class="w-1/4 justify-self-end">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 m-3">{{ __('public-profile.reviews') }}</h2>
                @if(auth()->user())
                    <form method="POST" action="{{ route('userReview.store', ['id' => $user->id]) }}">
                        @csrf
                        <label for="title" class="font-bold text-base text-gray-600 dark:text-gray-400">{{ __('advert.title') }}</label><br>
                        <input type="text" id="title" name="title" required class="w-full border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:border-gray-600">

                        <label for="review" class="font-bold text-base text-gray-600 dark:text-gray-400">{{ __('advert.review') }}</label><br>
                        <textarea id="review" name="review" rows="5" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"></textarea>
                        <button type="submit" class="mt-6 bg-transparent hover:bg-gray-800 text-gray-200 font-semibold hover:text-gray-200 py-2 px-4 border border-gray-200 hover:border-transparent rounded">{{ __('advert.submit_review') }}</button>
                    </form>
                @else
                    <p class="mt-2 text-base text-gray-800 dark:text-gray-200 font-bold">
                        {{ __('public-profile.login_to_comment') }}
                    </p>
                @endif
                @if(count($reviews) <= 0)
                    <p class="mt-2 text-base text-gray-600 dark:text-gray-400">
                        {{ __('public-profile.no_reviews') }}
                    </p>
                @else
                    @foreach($reviews as $review)
                        <x-user-review :review="$review"></x-user-review>
                    @endforeach
                @endif
            </aside>
        </div>
    </div>
</x-app-layout>
