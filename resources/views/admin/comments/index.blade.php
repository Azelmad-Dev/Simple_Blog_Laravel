<x-app-layout>

    <div class="py-12">

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                role="alert">
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex items-center justify-center">
            <div>
                <form action="{{ route('admin.comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $postCommentsWithUser->id }}">
                    <div class="sm:col-span-2">
                        <label for="content"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment
                            Content</label>
                        <input type="text" name="content" id="content"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Type Comment" value="{{ old('content') }}">
                        @error('content')
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                                {{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                        Comment
                    </button>
                </form>
                <div>
                    <div class="max-w-7xl sm:px-6 lg:px-8">
                        @foreach ($postCommentsWithUser->comments as $comment)
                            <div
                                class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-6">
                                <div class="px-5 py-3">
                                    <span class="dark:text-white ">Commented By : {{ $comment->user->name }}</span>
                                </div>
                                <div class="p-5">
                                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $comment->content }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.comments.edit', $comment) }}"
                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        onclick="return confirm('Are you sure You want to delete this comment?')"
                                        class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>

</x-app-layout>
