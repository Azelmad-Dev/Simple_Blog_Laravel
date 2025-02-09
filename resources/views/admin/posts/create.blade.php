<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6">
                <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                    <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-white">Add a New Post</h2>
                    <form action="{{ route('admin.posts.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid gap-6 sm:grid-cols-2">
                            <div class="sm:col-span-2">
                                <label for="title"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Post Title</label>
                                <input type="text" name="title" id="title"
                                    class="w-full mt-1 p-2 border rounded-lg text-gray-900 bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Enter post title" value="{{ old('title') }}">
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="category_id"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select id="category_id" name="category_id"
                                    class="w-full mt-1 p-2 border rounded-lg text-gray-900 bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="content"
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="content" name="content" rows="6"
                                    class="w-full mt-1 p-2 border rounded-lg text-gray-900 bg-gray-50 dark:bg-gray-700 dark:text-white dark:border-gray-600 focus:ring-primary-500 focus:border-primary-500"
                                    placeholder="Your content here">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                            Add Post
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
