<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div  class="flex w-full flex-col items-center bg-gray-100 pt-6 dark:bg-gray-900 mt-10 sm:pt-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex justify-start align-start flex-col gap-y-10">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 pb-0 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a
                    class="block max-w-fit px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                    href="{{ route('new-advert') }}">
                        Create New Advert
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
