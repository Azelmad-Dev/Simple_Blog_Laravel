<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-200 leading-tight text-center">
            {{ __('These Posts Belong To You') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <!-- Success Message -->
        @if (session('success'))
            <div class="max-w-2xl mx-auto p-4 mb-6 text-sm text-green-800 bg-green-50 border border-green-300 rounded-lg dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Add Post Button -->
        <div class="flex justify-center mb-6">
            <a href="{{ route('user.posts.create') }}"
                class="px-6 py-2.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition">
                Add Post
            </a>
        </div>

        <!-- Post Cards Container -->
        <div class="max-w-7xl mx-auto grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 sm:px-6 lg:px-8">
            @foreach ($user->posts as $post)
                <!-- Post Card -->
                <div class="bg-white border border-gray-200 rounded-xl shadow-lg dark:bg-gray-800 dark:border-gray-700">

                    <!-- Post Author & Category -->
                    <div class="flex justify-between items-center bg-gray-100 dark:bg-gray-900 px-5 py-3 rounded-t-xl">
                        <span class="text-sm font-medium text-gray-800 dark:text-gray-300">
                            {{ $user->name }}
                        </span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $post->category->name }}
                        </span>
                    </div>

                    <!-- Post Content -->
                    <div class="p-5">
                        <a href="#">
                            <h5
                                class="mb-2 text-xl font-bold text-gray-900 dark:text-white hover:text-blue-600 transition">
                                {{ $post->title }}
                            </h5>
                        </a>
                        <p class="mb-4 text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $post->content }}
                        </p>

                        <!-- Read More Button -->
                        <a href="{{ route('user.posts.show', $post) }}"
                            class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition hover:scale-105">
                            Read More
                            <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</x-app-layout>
