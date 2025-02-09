<x-app-layout>
    <div
        class="max-w-md mx-auto bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 mt-8">
        <!-- Post Author & Category -->
        <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-900 px-5 py-3 rounded-t-lg">
            <span class="text-sm font-medium text-gray-800 dark:text-gray-300">{{ $post->user->name }}</span>
            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $post->category->name }}</span>
        </div>

        <!-- Post Content -->
        <div class="p-6">
            <a href="#">
                <h5 class="mb-3 text-2xl font-bold text-gray-900 dark:text-white hover:text-blue-600 transition">
                    {{ $post->title }}
                </h5>
            </a>
            <p class="mb-4 text-gray-700 dark:text-gray-300 leading-relaxed">
                {{ $post->content }}
            </p>

            <!-- Actions (Edit, Delete, Comments) -->
            <div class="flex gap-3">
                @canany(['update', 'delete'], $post)
                    <!-- Edit Button -->
                    <a href="{{ route('user.posts.edit', $post) }}"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Edit
                    </a>

                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('user.posts.destroy', $post) }}" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure?')"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Delete
                        </button>
                    </form>
                @endcanany

                <!-- Comments Button -->
                <a href="{{ route('user.comments.of_selected_post', $post) }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-lg hover:bg-blue-700 transition hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Comments
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
