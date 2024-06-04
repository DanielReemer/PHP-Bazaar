<x-app-layout>
    <div class="max-w-7xl mx-auto p-6 lg:p-8 flex gap-20">
        <aside class="mt-24">
            <x-nav-link :href="route('products.show', ['type' => 'hired'])" :active="$data['type'] == 'hired'" class="m-5 text-xl">
                {{ __('products.hired') }}
            </x-nav-link>
            <br>
            <x-nav-link :href="route('products.show', ['type' => 'bought'])" :active="$data['type'] == 'bought'" class="m-5 text-xl">
                {{ __('products.bought') }}
            </x-nav-link>
        </aside>
        <section class="w-full">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white m-6">
                    {{ __('products.'.$data['type'].'_products') }}
                </h1>
                <hr class="border-gray-500">
            </div>

            <div class="flex flex-col gap-10 pt-6">
                @if($data['type'] == 'bought')
                    @foreach($data['products'] as $product)
                        <x-products.bought :product="$product"></x-products.bought>
                    @endforeach
                @elseif($data['type'] == 'hired')
                    @foreach($data['products'] as $product)
                        <x-products.hired :product="$product"></x-products.hired>
                    @endforeach
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
