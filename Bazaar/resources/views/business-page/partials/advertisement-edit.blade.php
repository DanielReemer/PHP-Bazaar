<div class="flex">
    <div class="block w-3/4">
        <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-3">{{ __('business.construct.'.$component['type']) }}</h2>
        <label for="{{ $component['type'] }}.rowlength.{{ $component['id'] }}" class="text-base text-gray-800 dark:text-gray-200 mt-5">{{ __('business.construct.amount_in_row') }}</label>
        <select name="{{ $component['type'] }}.rowlength.{{ $component['id'] }}" id="{{ $component['type'] }}.rowlength.{{ $component['id'] }}" class="bg-gray-50 bg-none border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-fit p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @for($i = 0; $i < 8; $i++)
                <option {{ $component['arguments']->rowlength == $i+1 ? 'selected' : '' }} value="{{ $i+1 }}">{{ $i+1 }}</option>
            @endfor
        </select>

        <h3 class="text-base text-gray-800 dark:text-gray-200 mt-5">{{ __('business.construct.select_advertisements') }}</h3>
        @for($i = 0; $i < count($adverts); $i++)
            <div class="flex w-3/4 items-center ps-4">
                <input id="{{ $component['type'] }}.adverts.{{ $component['id'] }}.{{ $i }}" type="checkbox" value="{{$adverts[$i]->id}}" {{ in_array($adverts[$i]->id, $component['arguments']->adverts) ? 'checked' : '' }} name="{{ $component['type'] }}.adverts.{{ $component['id'] }}.{{ $i }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                <label for="{{ $component['type'] }}.adverts.{{ $component['id'] }}.{{ $i }}" class="w-full py-2 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $adverts[$i]->title }}</label>
            </div>
        @endfor
    </div>

    <button type="submit" name="action" value="delete-{{ $component['id'] }}" class="size-5 bg-transparent hover:bg-red-200 text-red-300 font-semibold hover:text-red-700 border border-red-300 hover:border-transparent rounded">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
