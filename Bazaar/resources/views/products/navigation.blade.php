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
            <x-nav-link class="m-5 text-xl" :href="route('products.show', ['type' => 'my_product'])" :active="$data['type'] == 'my_product'">
                {{ __('products.my_product') }}
            </x-nav-link>
        </aside>
        <section class="w-full">
            <div class="w-full">
                <h1 class="m-6 text-3xl font-bold text-gray-900 dark:text-white">
                    {{ __('products.' . $data['type'] . '_products') }}
                </h1>
                <hr class="border-gray-500">
            </div>

            @livewire('products-component', ['data' => $data ])
        
        </section>
    </div>
</x-app-layout>
