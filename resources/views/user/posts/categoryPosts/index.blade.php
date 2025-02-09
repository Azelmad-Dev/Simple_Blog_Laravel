<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-200 leading-tight text-center">
            {{ __('These Posts Belong To ') . $category->name }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-200">Your Posts</h3>
                <a href=""
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    + Add Post
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach ($categories->posts as $post)
                    <div
                        class="bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                        <div class="px-5 py-3 bg-gray-100 dark:bg-gray-900">
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $post->user->name }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">| {{ $categories->name }}</span>
                        </div>
                        <div class="p-5">
                            <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $post->title }}
                            </h5>
                            <p class="mb-3 text-gray-700 dark:text-gray-400 line-clamp-3">
                                {{ $post->content }}
                            </p>
                            <a href="{{ route('user.posts.show', $post) }}"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-700">
                                Read More
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
