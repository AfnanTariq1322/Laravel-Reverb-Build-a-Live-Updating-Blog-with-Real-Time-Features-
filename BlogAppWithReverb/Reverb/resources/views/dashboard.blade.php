<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <br>
    <div x-data="{showUpdateModal: null , showAddModal: false}" class="max-w-6xl mx-auto p-6 bg-white rounded-lg">
        <h3 class="text-lg font-semibold mb-4">Your Blogs </h3>

        <button @click="showAddModal = true" class="bg-green-500 text-white rounded-lg py-2 px-4 mb-4"> Add
            Blog</button>

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2 text-left">Title</th>
                    <th class="border border-gray-300 px-4 py-2 text-left">Content</th>

                    <th class="border border-gray-300 px-4 py-2 text-left">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Auth::user()->blogs as $blog)
                <tr class="border border-gray">
                    <td class="px-4 py-2">{{$blog->title}}</td>
                    <td class="px-4 py-2">{{$blog->content}}</td>
                    <td class="px-4 py-2">{{$blog->created_at->format('M d, Y')}}</td>
                    <td class="px-4">
                        <button @click="showUpdateModal = {{$blog->id}}" class="text-blue-500">Update</button>
                        <form action="{{route('blog.destroy',$blog->id)}}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-500">Delete</button>
                        </form>
                    </td>
                </tr>


                <div x-show="showUpdateModal === {{$blog->id}}" x-cloak
                    class="fixed inset-0 flex items-centet justify-center">
                    <div class="bg-white p-6 rounded-lg w-96">
                        <h3 class="text-lg font-semibold">Update Blog </h3>
                        <form action="{{route('blog.update',$blog->id)}}" method="POST">
                            @csrf @method('PUT')
                            <input type="text" name="title" value="{{$blog->title}}"
                                class="w-full p-2 border rounded-lg mb-2">

                            <textarea name="content" rows="4" class="w-full p-2 border rounded-lg mb-2">
                        {{$blog->content}}
                        </textarea>
                            <div class="flex justify-end">
                                <button type="button" @click="showUpdateModal = null"
                                    class="bg-gray-400 px-4 rounded-lg"> Cancel</button>
                                <button type="submit" class="bg-blue-400 px-4 rounded-lg"> Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </tbody>
            @endforeach
        </table>

        <div x-show="showAddModal" x-cloak class="fixed inset-0 flex items-centet bg-black justify-center">
            <div class="bg-white p-6 rounded-lg w-96">
                <h3 class="text-lg font-semibold">Add Blog </h3>
                <form action="{{route('blog.store')}}" method="POST">
                    @csrf  
                    <input type="text" name="title"  class="w-full p-2 border rounded-lg mb-2">

                    <textarea name="content" rows="4" class="w-full p-2 border rounded-lg mb-2">
                        
                        </textarea>
                    <div class="flex justify-end">
                        <button type="button" @click="showAddModal = null" class="bg-gray-400 px-4 rounded-lg">
                            Cancel</button>
                        <button type="submit" class="bg-blue-400 px-4 rounded-lg"> Add Blog</button>
                    </div>
                </form>
            </div>
        </div>


</x-app-layout>