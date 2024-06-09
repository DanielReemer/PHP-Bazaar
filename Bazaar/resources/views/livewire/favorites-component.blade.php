<div>
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
                <option value="non_rentals">{{ __('products.purchasable') }}</option>
            </select>
        </div>

        <div class="my-10 mb-4">
            <label class="my-2 block text-sm font-medium text-white"
                   for="sort">{{ __('products.sort') }}:</label>
            <select
                class="rounded-md border-gray-300 shadow-sm hover:cursor-pointer focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
                id="myProductsSort" name="myProductsSort" wire:click="$refresh" wire:model.live="myProductsSort">
                <option value="asc">{{ __('products.ascending') }}</option>
                <option value="desc">{{ __('products.descending') }}</option>
            </select>
        </div>
    </div>
    <div class="grid gap-6 lg:gap-8 mt-3">
        @foreach($favorites as $favorite)
            <x-advert-card :advert="$favorite->advert"/>
        @endforeach

        {{ $favorites->links('livewire::tailwind') }}
    </div>
</div>
