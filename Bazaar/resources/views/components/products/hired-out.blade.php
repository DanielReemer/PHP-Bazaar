<a class="duration-250 flex w-2/3 gap-10 rounded-lg bg-white from-gray-700/50 via-transparent p-3 shadow-2xl shadow-gray-500/20 transition-all focus:outline focus:outline-2 focus:outline-red-500 motion-safe:hover:scale-[1.01] dark:bg-gray-800/50 dark:bg-gradient-to-bl dark:shadow-none dark:ring-1 dark:ring-inset dark:ring-white/5"
    href="{{ route('advert.show', ['id' => $product->advert->id]) }}">
    <div class="w-2/3">
        <h2 class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $product->advert->title }}</h2>
        <p class="mt-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
            {{ $product->advert->description }}
        </p>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <span class="font-bold">{{ __('products.hired_at') }}</span> {{ $product->created_at }}
        </p>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <span class="font-bold">{{ __('products.hired_by') }}</span> {{ $product->user->name }}
        </p>
    </div>
    <div class="border-l-2 border-l-gray-600 dark:border-l-gray-400"></div>
    <div class="w-1/3 text-sm text-gray-600 dark:text-gray-400">
        <p class="mt-4 font-bold">{{ __('products.from') }}</p>
        <p>{{ $product->formatted_from }}</p>
        <p class="mt-4 font-bold">{{ __('products.to') }}</p>
        <p>{{ $product->formatted_to }}</p>
    </div>
</a>
