<div class="flex gap-10 w-2/3 p-3 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
    <a href="{{ route('advert.show', ['id' => $product->advert->id]) }}" class="w-2/3 no-underline">
        <div>
            <h2 class="mt-2 text-xl font-semibold text-gray-900 dark:text-white">{{ $product->advert->title }}</h2>
            <p class="mt-1 text-gray-500 dark:text-gray-400 text-base leading-relaxed">
                {{ $product->advert->description }}
            </p>
            <p class="mt-4 text-sm text-gray-600 dark:text-gray-400">
                <span class="font-bold">{{ __('products.hired_at') }}</span> {{ $product->created_at }}
            </p>
        </div>
    </a>
    <div class="border-l-2 border-l-gray-600 dark:border-l-gray-400"></div>
    <div class="w-1/3 text-sm text-gray-600 dark:text-gray-400">
        <p class="mt-4 font-bold">{{ __('products.from') }}</p>
        <p>{{ $product->formatted_from  }}</p>
        <p class="mt-4 font-bold">{{ __('products.to') }}</p>
        <p>{{ $product->formatted_to }}</p>
        @if(!$product->returned)
            <a href="{{ route('advert.return', ['id' => $product->id]) }}" class="mt-5 w-fit hover:cursor-pointer bg-transparent hover:bg-gray-200 text-gray-300 font-semibold hover:text-gray-700 py-2 px-4 border border-gray-300 hover:border-transparent rounded block">{{ __('products.return') }}</a>
        @else
            <p class="mt-4 font-bold">{{ __('products.wear_cost') }}</p>
            <p>€{{ $product->total_wear_cost }}</p>
        @endif
    </div>
</div>
