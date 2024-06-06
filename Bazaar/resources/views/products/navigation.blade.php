<x-app-layout>
    <div class="mx-auto flex max-w-7xl gap-20 p-6 lg:p-8">
        <aside class="mt-24">
            <x-nav-link class="m-5 text-xl" :href="route('products.show', ['type' => 'hired'])" :active="$data['type'] == 'hired'">
                {{ __('products.hired') }}
            </x-nav-link>
            <br>
            <x-nav-link class="m-5 text-xl" :href="route('products.show', ['type' => 'bought'])" :active="$data['type'] == 'bought'">
                {{ __('products.bought') }}
            </x-nav-link>
            <br>
            <x-nav-link class="m-5 text-xl" :href="route('products.show', ['type' => 'hired_out'])" :active="$data['type'] == 'hired_out'">
                {{ __('products.hired_out') }}
            </x-nav-link>
        </aside>
        <section class="w-full">
            <div class="w-full">
                <h1 class="m-6 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('products.' . $data['type'] . '_products') }}
                </h1>
                <hr class="border-gray-500">
            </div>

            <div class="flex flex-col gap-10 pt-6">
                @foreach ($data['products'] as $product)
                    @if ($data['type'] == 'bought')
                        <x-products.bought :product="$product"></x-products.bought>
                    @elseif($data['type'] == 'hired')
                        <x-products.hired :product="$product"></x-products.hired>
                    @elseif($data['type'] == 'hired_out')
                        <x-products.hired-out :product="$product"></x-products.hired-out>
                    @endif
                @endforeach

            </div>
        </section>
    </div>
</x-app-layout>
