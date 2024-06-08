<a class="duration-250 flex w-2/3 gap-10 rounded-lg bg-white from-gray-700/50 via-transparent p-3 shadow-2xl shadow-gray-500/20 transition-all focus:outline focus:outline-2 focus:outline-red-500 motion-safe:hover:scale-[1.01] dark:bg-gray-800/50 dark:bg-gradient-to-bl dark:shadow-none dark:ring-1 dark:ring-inset dark:ring-white/5"
    href="{{ route('advert.show', ['id' => $product->id]) }}">
    <div class="w-2/3">
        <h2 class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $product->title }}</h2>
        <p class="mt-1 text-base leading-relaxed text-gray-500 dark:text-gray-400">
            {{ $product->description }}
        </p>
        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <span class="font-bold">{{ __('products.is_rental') }}?</span>
            {{ $product->is_rental ? __('products.true') : __('products.false') }}
        </p>

        <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            <span class="font-bold">{{ __('products.expires_at') }}</span> {{ $product->expiration_date }}
        </p>
    </div>
</a>
