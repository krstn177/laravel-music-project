<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            ✏️ Edit Photo
        </h2>
    </x-slot>

    <div class="max-w-xl mx-auto p-6">

        <img src="{{ asset('storage/' . $photo->path) }}" class="w-full rounded mb-4">

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.photos.update', $photo) }}">
            @csrf
            @method('PATCH')

            <label class="block mb-2 font-semibold">Title</label>
            <input type="text" name="title" value="{{ $photo->title }}" class="border p-2 w-full mb-4">

            <label class="block mb-2 font-semibold">Replace Image (optional)</label>
            <input type="file" name="photo" class="border p-2 w-full mb-4">

            <button class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
        </form>

    </div>
</x-app-layout>