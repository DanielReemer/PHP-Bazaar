<x-app-layout>
        <div class="w-2/3 mx-auto p-6 lg:p-8 flex gap-10">

            <div class="flex-1">
                <header class="mt-6 text-3xl font-semibold text-gray-900 dark:text-white w-100">
                    {{ __('advert.return.return_advert') }}
                </header>

                <form action="{{ route('advert.return.submit', ['id' => $hired_advert->id]) }}" method="post" class="mt-4 grid gap-4" enctype="multipart/form-data">
                    @csrf

                    <h1 class="block mt-3 text-xl font-medium text-gray-900 dark:text-white">
                        {{ $advert->title }}
                    </h1>

                    <label for="images" class="block mt-3 text-sm font-medium text-gray-900 dark:text-white">{{ __('advert.return.upload_images') }}</label>
                    <input type="file" id="images" name="images[]" accept="image/png, image/gif, image/jpeg, image/jpg" multiple class="block w-fit text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">

                    <ul class="text-sm text-red-600 dark:text-red-400">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <div class="flex">
                        <p class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-e-0 border-gray-300 border-e-0 rounded-s-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                            {{ __('advert.return.total_wear_cost') }}
                        </p>
                        <p class="rounded-none rounded-e-lg bg-gray-50 border text-gray-900 focus:ring-blue-500 focus:border-blue-500 block w-fit text-sm border-gray-300 p-2  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            €{{ $cost }}
                        </p>
                    </div>

                    <button type="submit" class="mt-5 w-fit hover:cursor-pointer bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 py-2 px-4 border border-gray-300 hover:border-transparent rounded block">
                        {{ __('advert.return.submit') }}
                    </button>
                </form>
            </div>

        </div>

</x-app-layout>
