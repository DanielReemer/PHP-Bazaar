<div class="m-2 mt-5 border-gray-600 dark:border-gray-400 rounded border-s-2 pl-2">
    <h3 class="text-lg text-gray-800 dark:text-gray-200">
        {{ $review->rating }} / 5 &nbsp;|&nbsp;{{ $review->title }}
    </h3>
    <p class="text-sm text-gray-500 dark:text-gray-500">
        <a href="{{ route('profile.show', ['id' => $review->user->id]) }}">{{ $review->user->name }}</a>
        | {{ $review->edited_at == null ? $review->created_at : $review->edited_at }}
    </p>

    <p class="text-base text-gray-600 dark:text-gray-400">
        {{ $review->comment }}
    </p>
</div>
