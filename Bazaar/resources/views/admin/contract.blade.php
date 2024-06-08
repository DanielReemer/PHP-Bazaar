<x-app-layout>
    <div class="w-2/3 mx-auto p-6 lg:p-8 flex gap-10">

        <div class="flex-1">
            <header class="mt-6 text-xl font-semibold text-gray-900 dark:text-white w-100">
                {{ __('contract.upload_contract') }}
            </header>

            <form action="{{ route('admin.contract.store') }}" method="post" class="mt-4 grid gap-4" enctype="multipart/form-data">
                @csrf

                <div>
                    <label for="contract" class="block font-medium text-base text-gray-700 dark:text-gray-300">{{ __('contract.select_file') }}</label>
                    <input type="file" id="contract" name="contract" accept="application/pdf" class="font-medium text-base text-gray-700 dark:text-gray-300">
                </div>

                <div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                        {{ __('contract.upload') }}
                    </button>
                </div>
            </form>
        </div>
        <div class="flex-1">
            <header class="mt-6 text-xl font-semibold text-gray-900 dark:text-white w-100">
                {{ __('contract.export_contract') }}
            </header>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-4 ">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">{{ __('contract.file_name') }}</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($files as $file)
                        <tr class="border-t border-gray-500">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $file['name'] }}</th>
                            <td class="px-6 py-4"><a href="{{ route('admin.contract.download', ['rawFile' => $file['name']]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('contract.download') }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
