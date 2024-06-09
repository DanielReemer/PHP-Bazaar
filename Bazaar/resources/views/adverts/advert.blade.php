<x-app-layout>
    <div class="w-3/4 mx-auto p-6 lg:p-8 flex gap-20">
        <div class="w-3/5">
            <div class="flex">
                <form method="POST" action="{{ route('favoriteAdvert.update', ['id' => $data['advert']->id]) }}">
                    @csrf
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-6">
                        {{ $data['advert']->title }}
                        @if(auth()->user())
                            <button name="favouriteButton" type="submit">
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
                <form method="POST" action="{{ route('advertReview.store', ['id' => $data['advert']->id]) }}" class="w-3/4">
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
        <div class="w-2/5">
            <div class="p-5 w-3/4">
                <div class="flex justify-center">
                    {{ $data['qrcode'] }}
                </div>
                <hr class="mt-5 mb-5">
                <div class="m-5">
                    <p class="text-base font-bold text-gray-800 dark:text-gray-200">{{ __('advert.advert_by') }}</p>
                    <p class="text-base text-gray-700 dark:text-gray-300">
                        <a href="{{ route('profile.show', ['id' => $data['advert']->owner->id]) }}">{{ $data['advert']->owner->name }}</a>
                    </p>
                        @if($data['advert']->is_rental === 1)
                            @if(auth()->user())
                                <form method="post" action="{{ route('advert.hire', ['id' => $data['advert']->id]) }}" class="mt-5">
                                    @csrf
                                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('advert.rent') }}</h2>
                                    <div class="flex flex-col">
                                        <label for="rent_start" class="w-full py-2 text-base font-medium text-gray-900 dark:text-gray-300">{{ __('advert.start_date') }}</label>
                                        <input type="date" name="rent_start" id="rent_start" class="w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                        <x-input-error :messages="$errors->get('rent_start')" class="mt-2"/>
                                    </div>
                                    <div class="flex flex-col">
                                        <label for="rent_end-end" class="w-full py-2 text-base font-medium text-gray-900 dark:text-gray-300">{{ __('advert.end_date') }}</label>
                                        <input type="date" name="rent_end" id="rent_end" class="w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                        <x-input-error :messages="$errors->get('rent_end')" class="mt-2"/>
                                    </div>
                                    <input type="submit" value="{{ __('advert.hire') }}" class="mt-5 hover:cursor-pointer w-fit bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 py-2 px-4 border border-gray-300 hover:border-transparent rounded">
                                </form>
                            @endif
                        @else
                            @if(auth()->user() && $data['advert']->post_status_id != 4)
                                <form method="post" action="{{ route('advert.bid', ['id' => $data['advert']->id]) }}" class="mt-5">
                                    @csrf
                                    <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('advert.buy') }}</h2>
                                    <div class="flex flex-col">
                                        <label for="money" class="w-full py-2 text-base font-medium text-gray-900 dark:text-gray-300">{{ __('advert.amount') }}</label>
                                        <input type="number" name="money" id="money" step=".01" class="w-fit bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <x-input-error :messages="$errors->get('bid')" class="mt-2"/>
                                    </div>
                                    <input type="submit" value="{{ __('advert.bid') }}" class="mt-5 hover:cursor-pointer w-fit bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 py-2 px-4 border border-gray-300 hover:border-transparent rounded">
                                </form>
                            @endif
                            <h2 class="text-lg mt-10 font-bold text-gray-800 dark:text-gray-200">{{ __('advert.bids') }}</h2>
                            @foreach($data['bids'] as $bid)
                                    @if(auth()->user() && $data['advert']->post_status_id != 4 && $data['advert']->owner_id == $data['user']->id)
                                        <form method="post" action="{{ route('advert.accept', ['id' => $bid->id]) }}">
                                            @csrf
                                    @endif
                                        <li class="p-3 list-none border-y-gray-500 border-y">
                                            <div class="flex justify-between items-center space-x-4 rtl:space-x-reverse">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    {{ $bid->user->name }}
                                                </p>
                                                <div class="pr-4 inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                    €{{ $bid->money }}
                                                </div>
                                                @if(auth()->user() && $data['advert']->post_status_id != 4 && $data['advert']->owner_id == $data['user']->id)
                                                    <input type="submit" class="hover:cursor-pointer w-fit bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 p-1 border border-gray-300 hover:border-transparent rounded" value="{{ __('advert.accept') }}">
                                                @endif
                                            </div>
                                        </li>
                                    @if(auth()->user() && $data['advert']->post_status_id != 4 && $data['advert']->owner_id == $data['user']->id)
                                        </form>
                                    @endif
                            @endforeach
                        @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
