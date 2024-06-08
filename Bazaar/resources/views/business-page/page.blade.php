<x-app-layout>
    <section class="w-full flex justify-center px-40 bg-[var(--primary-light)] dark:bg-[var(--primary-dark)]"
             style="--primary-light: {{ $page->primary_light }}; --primary-dark: {{ $page->primary_dark }};">
        @include('business-page.construct')
    </section>
</x-app-layout>
