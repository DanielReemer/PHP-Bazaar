<div>
    @if ($data['type'] == 'hired')
        <div class="flex flex-row gap-5">
            <!-- Dropdown for filtering -->
            <div class="my-10 mb-4">
                <label class="my-2 block text-sm font-medium text-white"
                       for="filter">{{ __('products.filter') }}:</label>
                <select
                    class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    id="filter" name="filter" wire:click="$refresh" wire:model.live="filter">
                    <option value="">{{ __('products.all') }}</option>
                    <option value="returned">{{ __('products.returned') }}</option>
                    <option value="not_returned">{{ __('products.not_returned') }}</option>
                </select>
            </div>

            <div class="my-10 mb-4">
                <label class="my-2 block text-sm font-medium text-white"
                       for="sort">{{ __('products.sort') }}:</label>
                <select
                    class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    id="myProductsSort" name="myProductsSort" wire:click="$refresh" wire:model.live="myProductsSort">
                    <option value="from_asc">{{ __('products.from_date_asc') }}</option>
                    <option value="from_desc">{{ __('products.from_date_desc') }}</option>
                    <option value="to_asc">{{ __('products.to_date_asc') }}</option>
                    <option value="to_desc">{{ __('products.to_date_desc') }}</option>
                </select>
            </div>
        </div>
    @endif
    @if ($data['type'] == 'bought')
        <div class="flex flex-row gap-5">
            <!-- Dropdown for filtering -->
            <div class="my-10 mb-4">
                <label class="my-2 block text-sm font-medium text-white"
                       for="sort">{{ __('products.sort') }}:</label>
                <select
                    class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    id="myProductsSort" name="myProductsSort" wire:click="$refresh" wire:model.live="myProductsSort">
                    <option value="asc">{{ __('products.bought_date_asc') }}</option>
                    <option value="desc">{{ __('products.bought_date_desc') }}</option>
                </select>
            </div>
        </div>
    @endif
    @if ($data['type'] == 'hired_out')
        <div class="flex flex-row gap-5">
            <!-- Dropdown for filtering -->
            <div class="my-10 mb-4">
                <label class="my-2 block text-sm font-medium text-white"
                    for="filter">{{ __('products.filter') }}:</label>
                <select
                    class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    id="filter" name="filter" wire:click="$refresh" wire:model.live="filter">
                    <option value="">{{ __('products.all') }}</option>
                    <option value="giving">{{ __('products.giving') }}</option>
                    <option value="recieving">{{ __('products.recieving') }}</option>
                </select>
            </div>

            <div class="my-10 mb-4">
                <label class="my-2 block text-sm font-medium text-white"
                    for="sort">{{ __('products.sort') }}:</label>
                <select
                    class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    id="myProductsSort" name="myProductsSort" wire:click="$refresh" wire:model.live="myProductsSort">
                    <option value="from_asc">{{ __('products.from_date_asc') }}</option>
                    <option value="from_desc">{{ __('products.from_date_desc') }}</option>
                    <option value="to_asc">{{ __('products.to_date_asc') }}</option>
                    <option value="to_desc">{{ __('products.to_date_desc') }}</option>
                </select>
            </div>
        </div>
    @endif
    @if ($data['type'] == 'my_product')
        <div class="flex flex-row gap-5">
            <!-- Dropdown for filtering -->
            <div class="my-10 mb-4">
                <label class="my-2 block text-sm font-medium text-white"
                    for="filter">{{ __('products.filter') }}:</label>
                <select
                    class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    id="filter" name="filter" wire:click="$refresh" wire:model.live="filter">
                    <option value="">{{ __('products.all') }}</option>
                    <option value="rentals">{{ __('products.rentals') }}</option>
                    <option value="non_rentals">{{ __('products.non_rentals') }}</option>
                </select>
            </div>

            <div class="my-10 mb-4">
                <label class="my-2 block text-sm font-medium text-white"
                    for="sort">{{ __('products.sort') }}:</label>
                <select
                    class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                    id="myProductsSort" name="myProductsSort" wire:click="$refresh" wire:model.live="myProductsSort">
                    <option value="asc">{{ __('products.ex_date_asc') }}</option>
                    <option value="desc">{{ __('products.ex_date_desc') }}</option>

                </select>
            </div>
        </div>
    @endif

    <!-- Products list -->
    <div class="flex flex-col gap-10 pt-6">
        @foreach ($products as $product)
            @if ($data['type'] == 'bought')
                <x-products.bought wire:key="{{ $product->id }}" :product="$product"></x-products.bought>
            @elseif($data['type'] == 'hired')
                <x-products.hired wire:key="{{ $product->id }}" :product="$product"></x-products.hired>
            @elseif($data['type'] == 'hired_out')
                <x-products.hired-out wire:key="{{ $product->id }}" :product="$product"></x-products.hired-out>
            @elseif($data['type'] == 'my_product')
                <x-products.my-product wire:key="{{ $product->id }}" :product="$product"></x-products.my-product>
            @endif
        @endforeach

        {{ $products->links('livewire::tailwind') }}

    </div>
</div>
