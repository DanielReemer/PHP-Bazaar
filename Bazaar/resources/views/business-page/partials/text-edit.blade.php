<h2 class="text-lg font-bold text-gray-800 dark:text-gray-200">{{ __('business.construct.'.$component['type']) }}</h2>

<label for="{{ $component['type'] }}.header.{{ $component['id'] }}" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('business.construct.header') }}</label>
<input type="text" id="{{ $component['type'] }}.header.{{ $component['id'] }}" name="{{ $component['type'] }}.header.{{ $component['id'] }}" value="{{ $component['arguments']->header }}" class="block w-1/2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></input>

<div class="mt-5">
    <label for="{{ $component['type'] }}.body.{{ $component['id'] }}" class="block mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('business.construct.body') }}</label>
    <textarea id="{{ $component['type'] }}.body.{{ $component['id'] }}" name="{{ $component['type'] }}.body.{{ $component['id'] }}" rows="4" class="block w-1/2 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $component['arguments']->body }}</textarea>
</div>
