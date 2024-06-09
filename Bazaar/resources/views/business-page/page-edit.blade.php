<x-app-layout>
    <form class="flex w-full" action="{{ route('page.update', ['slug' => $page->url]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <aside class="w-1/4 p-14 bg-gray-300 dark:bg-gray-700 border border-gray-200 dark:border-gray-600">
            @include('business-page.sidebar')
        </aside>
        <section class="w-3/4 flex justify-center max-h-[calc(100vh-5rem)] overflow-y-auto">
            @include('business-page.construct')
        </section>
    </form>
</x-app-layout>
