<div class="grid grid-cols-{{ $component['arguments']["rowlength"] }} gap-6 lg:gap-8 mt-3">
    @foreach($component['arguments']["adverts"] as $advert)
        <x-advert-card :advert="$advert"/>
    @endforeach
</div>
