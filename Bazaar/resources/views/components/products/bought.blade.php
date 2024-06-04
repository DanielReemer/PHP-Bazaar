<a href="{{ route('advert.show', ['id' => $product->advert->id]) }}" class="w-2/3 p-3 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
    <div>
        <h2 class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $product->advert->title }}</h2>
        <p class="mt-1 text-gray-500 dark:text-gray-400 text-base leading-relaxed">
            {{ $product->advert->description }}
        </p>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <span class="font-bold">{{ __('products.bought_at') }}</span> {{ $product->created_at }}
        </p>
    </div>
</a>
