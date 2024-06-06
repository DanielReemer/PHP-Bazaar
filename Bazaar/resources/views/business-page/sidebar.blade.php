<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
    {{ __('business.sidebar.edit') }}
</h1>

<div class="mt-5">
    <h2 class="text-xl text-gray-700 dark:text-gray-300">
        {{ __('business.sidebar.background-colors') }}
    </h2>

    <div>
        <div class="mt-3">
            <label for="primary-light" class="text-base bold text-gray-600 dark:text-gray-400 font-semibold">
                {{ __('business.sidebar.primary-light') }}
            </label>
            <input type="color" id="primary-light" name="primary-light" value="{{ $page->primary_light }}" class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-600 dark:border-gray-800">
        </div>

        <div class="mt-3">
            <label for="primary-dark" class="text-base bold text-gray-600 dark:text-gray-400 font-semibold">
                {{ __('business.sidebar.primary-dark') }}
            </label>
            <input type="color" id="primary-dark" name="primary-dark" value="{{ $page->primary_dark }}" class="p-1 h-10 w-14 block bg-white border border-gray-200 cursor-pointer rounded-lg disabled:opacity-50 disabled:pointer-events-none dark:bg-gray-600 dark:border-gray-800">
        </div>
    </div>
</div>

<div class="mt-5">
    <h2 class="text-xl text-gray-700 dark:text-gray-300">
        {{ __('business.sidebar.components') }}
    </h2>

    <div class="flex flex-wrap gap-3 mt-3">
        <button type="submit" name="action" value="text" class="bg-gray-100 rounded border-2 border-gray-300 size-24 flex flex-col justify-center items-center text-sm bold text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" class="w-14 h-14 text-gray-700">
                <path d="M12 3V21M9 21H15M19 6V3H5V6" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ __('business.sidebar.text') }}
        </button>
        <button type="submit" name="action" value="image" class="bg-gray-100 rounded border-2 border-gray-300 size-24 flex flex-col justify-center items-center text-sm bold text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg"  class="w-14 h-14 text-gray-700" viewBox="0 0 24 24" fill="none">
                <path d="M14.2639 15.9375L12.5958 14.2834C11.7909 13.4851 11.3884 13.086 10.9266 12.9401C10.5204 12.8118 10.0838 12.8165 9.68048 12.9536C9.22188 13.1095 8.82814 13.5172 8.04068 14.3326L4.04409 18.2801M14.2639 15.9375L14.6053 15.599C15.4112 14.7998 15.8141 14.4002 16.2765 14.2543C16.6831 14.126 17.12 14.1311 17.5236 14.2687C17.9824 14.4251 18.3761 14.8339 19.1634 15.6514L20 16.4934M14.2639 15.9375L18.275 19.9565M18.275 19.9565C17.9176 20 17.4543 20 16.8 20H7.2C6.07989 20 5.51984 20 5.09202 19.782C4.71569 19.5903 4.40973 19.2843 4.21799 18.908C4.12796 18.7313 4.07512 18.5321 4.04409 18.2801M18.275 19.9565C18.5293 19.9256 18.7301 19.8727 18.908 19.782C19.2843 19.5903 19.5903 19.2843 19.782 18.908C20 18.4802 20 17.9201 20 16.8V16.4934M4.04409 18.2801C4 17.9221 4 17.4575 4 16.8V7.2C4 6.0799 4 5.51984 4.21799 5.09202C4.40973 4.71569 4.71569 4.40973 5.09202 4.21799C5.51984 4 6.07989 4 7.2 4H16.8C17.9201 4 18.4802 4 18.908 4.21799C19.2843 4.40973 19.5903 4.71569 19.782 5.09202C20 5.51984 20 6.0799 20 7.2V16.4934M17 8.99989C17 10.1045 16.1046 10.9999 15 10.9999C13.8954 10.9999 13 10.1045 13 8.99989C13 7.89532 13.8954 6.99989 15 6.99989C16.1046 6.99989 17 7.89532 17 8.99989Z" stroke="#374151" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            {{ __('business.sidebar.image') }}
        </button>
        <button class="bg-gray-100 rounded border-2 border-gray-300 size-24 flex flex-col justify-center items-center text-sm bold text-gray-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="#374151" class="w-14 h-14 text-gray-700" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M6,18 L6,20 C6,21.1045695 5.1045695,22 4,22 L2,22 C0.8954305,22 0,21.1045695 0,20 L1.25399691e-13,4 C1.25399691e-13,2.8954305 0.8954305,2 2,2 L4,2 L22,2 C23.1045695,2 24,2.8954305 24,4 L24,18 C24,19.1045695 23.1045695,20 22,20 L20,20 C18.8954305,20 18,19.1045695 18,18 L18,17 L15,17 L15,19 C15,20.1045695 14.1045695,21 13,21 L10,21 C8.8954305,21 8,20.1045695 8,19 L8,18 L6,18 Z M2,4 L2,20 L4,20 L4,14 L6,14 L6,16 L8,16 L8,14 L10,14 L10,19 L13,19 L13,14 L15,14 L15,15 L18,15 L18,14 L20,14 L20,18 L22,18 L22,4 L20,4 L2,4 Z M19,6 L19,8 L5,8 L5,6 L19,6 Z M16,10 L16,12 L5,12 L5,10 L16,10 Z"/>
            </svg>
            {{ __('business.sidebar.advertisement') }}
        </button>
    </div>
</div>

<div class="mt-5 w-fit bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 py-2 px-4 border border-gray-300 hover:border-transparent rounded">
    <button type="submit">{{ __('business.sidebar.save') }}</button>
</div>
