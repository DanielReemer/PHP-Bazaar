<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('profile.profile') }}
        </h2>
    </x-slot>

    <div class="flex justify-center w-full mt-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl justify-between flex">
                    @include('profile.partials.show-accounttype')
                    @if($user->role_id == 3 && $user->landing_page->url != null)
                        <div class="self-center p-2 ml-5 size-fit justify-self-end bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 border border-gray-300 hover:border-transparent rounded">
                            <a href="{{ route('page.showEdit', ["slug" => $user->landing_page->url]) }}" target="_blank">{{ __('profile.edit_business_page') }}</a>
                        </div>
                    @else
                        <div class="self-center p-2 ml-5 size-fit justify-self-end bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 border border-gray-300 hover:border-transparent rounded">
                            <a href="#">{{ __('profile.edit_business_page') }}</a>
                        </div>
                    @endif
                </div>
            </div>

            @if(auth()->user()->role_id == 3)
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-custom-url-form')
                    </div>
                </div>
            @endif

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
