<div {{ $attributes->merge(['class' => 'p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg flex flex-col border-2 border-black border-solid dark:border-white w-72 min-w-72 max-w-fit']) }}>
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
            <!-- Apply to advert --> 
        </div>
    </section>
</div>
