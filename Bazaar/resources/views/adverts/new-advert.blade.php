<x-app-layout>
    <div class="flex min-h-screen flex-col items-center bg-gray-100 pt-6 dark:bg-gray-900 sm:justify-center sm:pt-0">
        <header class="w-100 mt-6 text-center text-xl font-semibold text-gray-900 dark:text-white">
            {{ __('advertPostForm.create') }}
        </header>
        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md dark:bg-gray-800 sm:max-w-md sm:rounded-lg">
            <form class="flex flex-col gap-5" method="POST" action="{{ route('new-advert') }}">
                @csrf

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('advertPostForm.title')" />
                    <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" :value="old('title')"
                        required autofocus autocomplete="title" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" :value="__('advertPostForm.description')" />
                    <x-text-input class="mt-1 block w-full" id="description" name="description" type="text"
                        :value="old('description')" required autofocus autocomplete="description" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Is rental advertisement -->
                <div>
                    <x-input-label for="rental" :value="__('advertPostForm.is_rental')" />
                    <input
                        class="form-checkbox rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                        id="rental" name="rental" type="checkbox" value='1' />
                    <x-input-error class="mt-2" :messages="$errors->get('rental')" />
                </div>


                <!-- submit -->
                <div class="mt-4 flex items-center justify-start">
                    <x-primary-button class="" name="submitAdvertForm">
                        {{ __('advertPostForm.post') }}
                    </x-primary-button>
                </div>
            </form>

            <form class="flex flex-col gap-5" method="POST" action="{{ route('new-advert-csv') }}"
                enctype="multipart/form-data">
                @csrf

                <!-- Csv input -->
                <input
                    class="w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 focus:border-blue-500 focus:outline-none"
                    id="csvFile" name="csv_file" type="file" accept=".csv">
                <!-- submit -->
                <div class="mt-4 flex items-center justify-start">
                    <x-primary-button class="" name="submitCsv">
                        {{ __('advertPostForm.post') }}
                    </x-primary-button>
                </div>
            </form>


            @if (Session::has('error'))
                <div class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
</x-app-layout>
