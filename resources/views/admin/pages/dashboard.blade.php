<x-admin.layout>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">
                Welcome Back, {{ Auth::user()->name }}!
            </h2>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <p class="text-gray-600 dark:text-gray-300">
                    {{ __("You're logged in as an Admin! ohh") }}
                </p>
            </div>
        </div>
    </div>
</x-admin.layout>
