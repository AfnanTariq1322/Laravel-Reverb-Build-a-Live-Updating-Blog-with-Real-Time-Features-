<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blogs') }}
        </h2>
    </x-slot>
    <br>
    <div x-data="{showUpdateModal: null , showAddModal: false}" class="max-w-6xl mx-auto p-6 bg-white rounded-lg">
        <h3 class="text-lg font-semibold mb-4">Your Blogs </h3>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">

                            <h3 class="text-xl font-semibold mb-6">Recent Blog Posts:</h3>

                            <!-- Blog Grid Layout -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="blog-list">
                                @foreach($blogs as $blog)
                                <div class="bg-white shadow-xl rounded-2xl overflow-hidden blog-item transform transition duration-300 hover:scale-105 hover:shadow-2xl"
                                    id="blog-{{ $blog->id }}">
                                    <div class="p-6">
                                        <h4 class="text-xl font-bold text-gray-900">{{ $blog->title }}</h4>
                                        <p class="text-sm text-gray-600">
                                            By <span
                                                class="font-semibold">{{ $blog->user->name ?? 'Unknown Author' }}</span>
                                            on
                                            {{ $blog->created_at ? $blog->created_at->format('M d, Y') : 'Unknown Date' }}
                                        </p>
                                        <p class="text-gray-700 mt-3">{{ Str::limit($blog->content, 100) }}</p>
                                        <a href="#"
                                            class="inline-block mt-4 text-blue-600 font-semibold hover:underline">Read
                                            More</a>
                                    </div>
                                </div>
                                @endforeach

                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>



</x-app-layout>