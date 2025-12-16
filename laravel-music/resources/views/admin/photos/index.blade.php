<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            📸 Admin – Photo Manager
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6">
        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.photos.store') }}" class="mb-6">
            @csrf
            <div class="flex gap-2">
                <input type="text" name="title" placeholder="Title (optional)" class="border p-2 flex-1">
                <input type="file" name="photo" class="border p-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
            </div>
        </form>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($photos as $photo)
                <div class="relative border rounded">
                    <img src="{{ asset('storage/' . $photo->path) }}" class="rounded w-full h-40 object-cover">

                    <div class="p-2">
                        <div class="font-semibold">
                            {{ $photo->title ?? 'No title' }}
                        </div>
                    </div>

                    <div class="flex justify-between p-2">
                        <a href="{{ route('admin.photos.edit', $photo) }}" class="text-blue-600">Edit</a>

                        <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>