<div class="w-2/3 mt-14">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
        {{ $page->user->name }}
    </h1>
    @foreach($components as $component)
        <div class="mt-10">
            @switch($component['type'])
                @case('text')
                    @if($public)
                        @include('business-page.partials.text')
                    @else
                        @include('business-page.partials.text-edit')

                        <hr class="mt-10 w-2/3">
                    @endif
                    @break
                @case('image')
                    @if($public)
                        @include('business-page.partials.image')
                    @else
                        @include('business-page.partials.image-edit')

                        <hr class="mt-10 w-2/3">
                    @endif
                    @break
                @case('advertisement')
                    @if($public)
                        @include('business-page.partials.advertisement')
                    @else
                        @include('business-page.partials.advertisement-edit')

                        <hr class="mt-10 w-2/3">
                    @endif
                    @break
            @endswitch
        </div>
    @endforeach
</div>
