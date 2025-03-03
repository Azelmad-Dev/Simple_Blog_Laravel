<x-admin.layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4 dark:bg-green-900/50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Categories Sidebar -->
                <div class="lg:w-64 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Categories</h3>
                        <div class="space-y-2">
                            @foreach ($categories as $category)
                                <a href="{{ route('admin.posts.index', ['category_id' => $category->id]) }}"
                                    class="block px-3 py-2 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-150">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="flex-1">
                    <div class="flex">
                        <div class="mb-6 mr-1">
                            <a href="{{ route('admin.posts.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Add Post
                            </a>
                        </div>
                        <div class="mb-6">
                            <a href="{{ route('admin.posts.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                All Posts
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($posts as $post)
                            <div
                                class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="w-full h-48 overflow-hidden">
                                    <img src="{{ Storage::url('posts/' . $post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-between items-center">
                                        <span
                                            class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $post->user->name }}</span>
                                        <span
                                            class="text-sm px-2 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 rounded-full">
                                            {{ $post->category->name }}
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                        {{ $post->title }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                        {{ $post->content }}
                                    </p>
                                    <div class="flex justify-end">
                                        <a href="{{ route('admin.posts.show', $post) }}"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150">
                                            Read more
                                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3">
                                <p class="text-center text-gray-600 dark:text-gray-400">
                                    There Is No Post Yet.
                                </p>
                            </div>
                        @endforelse
                        {{ $posts->onEachSide(2)->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
