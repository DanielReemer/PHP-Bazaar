<x-app-layout>
    <div class="mt-10 flex w-full flex-col items-center bg-gray-100 pt-6 dark:bg-gray-900 sm:pt-0">
        <header class="w-100 mt-6 text-center text-xl font-semibold text-gray-900 dark:text-white">
            {{ $createLabel }}
        </header>
        <div
            class="align-center mt-6 flex w-full flex-col justify-start gap-y-4 overflow-hidden bg-white px-6 py-4 shadow-md dark:bg-gray-800 sm:max-w-md sm:rounded-lg">
            <form class="flex flex-col gap-5" method="POST" action="{{ route('new-advert') }}">
                @csrf

                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="$titleLabel" />
                    <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" :value="old('title')"
                        required autofocus autocomplete="title" />
                    <x-input-error class="mt-2" :messages="$errors->get('title')" />
                </div>

                <!-- Description -->
                <div>
                    <x-input-label for="description" :value="$descriptionLabel" />
                    <x-text-input class="mt-1 block w-full" id="description" name="description" type="text"
                        :value="old('description')" required autofocus autocomplete="description" />
                    <x-input-error class="mt-2" :messages="$errors->get('description')" />
                </div>

                <!-- Is rental advertisement -->
                <div>
                    <x-input-label for="rental" :value="$isRentalLabel" />
                    <input
                        class="form-checkbox rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                        id="rental" name="rental" type="checkbox" value='1' />
                    <x-input-error class="mt-2" :messages="$errors->get('rental')" />
                </div>

                <!-- Link advertisements -->
                <div>
                    <p class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('advertPostForm.link_adverts') }}</p>
                    @for ($i = 0; $i < count($adverts); $i++)
                        <div class="flex w-3/4 items-center ps-4">
                            <input
                                class="h-4 w-4 rounded border-gray-300 bg-gray-100 text-blue-600 focus:ring-2 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800 dark:focus:ring-blue-600"
                                id="linked_advert_{{ $i }}" name="linked_advert[]" type="checkbox"
                                value="{{ $adverts[$i]->id }}">
                            <label class="ms-2 w-full py-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                for="linked_advert_{{ $i }}">{{ $adverts[$i]->title }}</label>
                        </div>
                    @endfor
                </div>


                <!-- submit -->
                <div class="mt-4 flex items-center justify-start">
                    <x-primary-button class="" name="submitAdvertForm">
                        {{ $postButtonText }}
                    </x-primary-button>
                </div>
            </form>
            @if ($isBusiness)
                <div class="border-white-300 mx-auto my-4 w-full border-t-2"></div>
                <form class="flex flex-col gap-5" method="POST" action="{{ route('new-advert-csv') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Csv input -->
                    <x-input-label for="csv_file" :value="$uploadFileLabel" />
                    <input
                        class="w-full appearance-none rounded border px-3 py-2 leading-tight text-white focus:border-blue-500 focus:outline-none"
                        id="csvFile" name="csv_file" type="file" accept=".csv">
                    <!-- submit -->
                    <div class="mt-4 flex items-center justify-start">
                        <x-primary-button class="" name="submitCsv">
                            {{ $uploadButtonText }}
                        </x-primary-button>
                    </div>
                </form>
            @endif
            @if (Session::has('error'))
                <div class="mt-2 space-y-1 text-sm text-red-600 dark:text-red-400">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
</x-app-layout>
