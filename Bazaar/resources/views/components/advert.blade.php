<div {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm']) }}>
    <section class="w-full flex flex-col gap-5">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ $advert->title }}
        </h2>
    </section>
    <section class="w-full flex flex-col gap-5">
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ $advert->description }}
        </p>
    </section>
    <section class="w-full flex flex-col gap-5">
        <div class="flex items-center justify-start mt-4">
            <x-primary-button class="">
                Apply
            </x-primary-button>
        </div>
    </section>
</div>
