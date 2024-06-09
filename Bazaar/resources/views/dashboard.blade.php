<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="align-start mx-auto flex max-w-7xl flex-col justify-start gap-y-10 sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <a class="block max-w-fit rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800 dark:active:bg-gray-300"
                        href="/new-advert">
                        Create New Advert
                    </a>
                </div>

            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="fixed bottom-4 right-4 rounded-md bg-green-500 px-4 py-2 text-white shadow-md" id="flash-message">
            {{ session('success') }}
        </div>
    @endif
</x-app-layout>
