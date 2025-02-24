<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-200 leading-tight text-center">
            {{ __('These Posts Belong To You') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6">
        @if (session('success'))
            <div class="p-4 mb-6 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Left Side: Categories -->
            <div class="col-span-1 p-5 bg-white dark:bg-gray-900 shadow-md rounded-lg">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach ($categories as $category)
                        <li>
                            <a class="text-blue-600 hover:text-blue-500 decoration-2 hover:underline focus:outline-none focus:underline opacity-90"
                                href="{{ route('user.posts.of_selected_category', $category) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Right Side: Posts -->
            <div class="col-span-3">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-200">Your Posts</h3>
                    <a href="{{ route('user.posts.create') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                        + Add Post
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($posts as $post)
                        <div
                            class="bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                            <div class="w-full h-48 overflow-hidden">
                                <img src="{{ Storage::url('posts/' . $post->image) }}" alt="{{ $post->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="px-5 py-3 bg-gray-100 dark:bg-gray-900">
                                <span
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $post->user->name }}</span>
                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">|
                                    {{ $post->category->name }}</span>
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

                    @empty($posts)
                        <div class="col-span-3">
                            <p class="text-center text-gray-600 dark:text-gray-400">
                                There Is No Post Yet.
                            </p>
                        </div>
                    @endempty
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
