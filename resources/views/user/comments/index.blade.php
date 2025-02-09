<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700" role="alert">
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8">
            <form action="{{ route('user.comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="post_id" value="{{ $postCommentsWithUser->id }}">
                <div class="mb-4">
                    <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Add your comment
                    </label>
                    <textarea name="content" id="content" rows="3"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white resize-none"
                        placeholder="What are your thoughts?">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors duration-200">
                    Post Comment
                </button>
            </form>
        </div>

        <div class="space-y-6">
            @foreach ($postCommentsWithUser->comments as $comment)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center">
                                    <span class="text-white font-medium">{{ substr($comment->user->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $comment->user->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>
                    </div>

                    @canany(['update', 'delete'], $comment)
                        <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700/50 rounded-b-lg flex gap-3">
                            <a href="{{ route('user.comments.edit', $comment) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('user.comments.destroy', $comment) }}"
                                class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Are you sure You want to delete this comment?')"
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-700 bg-white border border-red-300 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:bg-gray-800 dark:text-red-400 dark:border-red-600 dark:hover:bg-red-900/20">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endcanany
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
