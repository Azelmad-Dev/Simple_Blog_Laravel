<x-admin.layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section class="bg-white dark:bg-gray-900">
                <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new Post</h2>
                    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                            <div class="sm:col-span-2">
                                <label for="title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Post
                                    Title</label>
                                <input type="text" name="title" id="title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Type product name" value="{{ old('title', $post->title) }}">
                                @error('title')
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="category_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                <select id="category_id" name="category_id" value="{{ old('category') }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label for="content"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea id="content" name="content" rows="8"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Your Content here">{{ old('content', $post->content) }}</textarea>
                                @error('content')
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                        {{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Image Upload Field --}}
                            <div class="sm:col-span-2">
                                <label for="image"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Upload New
                                    Image</label>
                                <input type="file" name="image" id="image"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                @error('image')
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- Display Current Image --}}
                            @if ($post->image)
                                <div class="sm:col-span-2">
                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current
                                        Image</label>
                                    <img src="{{ Storage::url('posts/' . $post->image) }}" alt="{{ $post->title }}"
                                        class="w-full h-40 object-cover rounded-lg border border-gray-300 dark:border-gray-600">
                                </div>
                            @endif
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                            Update Post
                        </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</x-admin.layout>
