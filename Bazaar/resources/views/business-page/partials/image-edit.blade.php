<div class="flex">
    <div class="block w-3/4">
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('business.construct.'.$component['type']) }}</h2>

        <label for="{{ $component['type'] }}.url.{{ $component['id'] }}" class="block mt-3 text-sm font-medium text-gray-900 dark:text-white">{{ __('business.construct.upload_file') }}</label>
        <input type="file" id="{{ $component['type'] }}.url.{{ $component['id'] }}" name="{{ $component['type'] }}.url.{{ $component['id'] }}" value="{{ $component['arguments']->url }}" class="block w-3/4 text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">

        <label for="{{ $component['type'] }}.alt.{{ $component['id'] }}" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('business.construct.alt') }}</label>
        <input type="text" id="{{ $component['type'] }}.alt.{{ $component['id'] }}" name="{{ $component['type'] }}.alt.{{ $component['id'] }}" value="{{ $component['arguments']->alt }}" class="block w-3/4 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
    </div>

    <button type="submit" name="action" value="delete-{{ $component['id'] }}" class="size-5 bg-transparent hover:bg-red-200 text-red-300 font-semibold hover:text-red-700 border border-red-300 hover:border-transparent rounded">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
