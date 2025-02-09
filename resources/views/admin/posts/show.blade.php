<x-app-layout>
    <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-6">
        <span class="dark:text-white ">{{ $post->user->name }}</span>
        <span class="dark:text-white ">{{ $post->category->name }}</span>
        <div class="p-5">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $post->title }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $post->content }}</p>

            <div class="flex gap-2">
                <a href="{{ route('admin.posts.edit', $post) }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Edit
                </a>
                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure?')"
                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Delete
                    </button>
                </form>
                <a href="{{ route('admin.comments.of_selected_post', $post) }}"
                    class="px-4 py-2 text-sm font-medium text-white bg-blue-900 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    Comments
                </a>
            </div>

        </div>
    </div>
</x-app-layout>
