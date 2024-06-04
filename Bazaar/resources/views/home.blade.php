
<x-app-layout>
    <div class="">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="mt-16">
                <div class="grid grid-cols-3 gap-6 lg:gap-8">
                    @foreach($adverts as $advert)
                        <x-advert-card :advert="$advert"/>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
