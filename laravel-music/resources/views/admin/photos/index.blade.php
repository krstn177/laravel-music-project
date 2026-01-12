<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            📸 Admin – Photo Manager
        </h2>
    </x-slot>

    <div class="max-w-5xl mx-auto p-6">
        <style>
            .photo-portrait { position: relative; width: 100%; padding-top: 100%; overflow: hidden; }
            .photo-portrait img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
            .photo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1rem; }
        </style>

        @if(session('success'))
            <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @can('create', App\Models\Photo::class)
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.photos.store') }}" class="mb-6">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="title" placeholder="Title (optional)" class="border p-2 flex-1">
                    <input type="file" name="photo" class="border p-2">
                    <button class="bg-blue-500 text-black px-4 py-2 rounded">Upload</button>
                </div>
            </form>
        @endcan

        <div class="photo-grid">
            @foreach($photos as $photo)
                <div class="relative border rounded overflow-hidden">
                    <div class="photo-portrait bg-gray-100">
                        <img src="{{ asset('storage/' . $photo->path) }}" alt="Photo">
                    </div>

                    <div class="p-2">
                        <div class="font-semibold text-sm">
                            {{ $photo->title ?? 'No title' }}
                        </div>
                    </div>

                    <div class="flex justify-between p-2 gap-2">
                        @can('update', $photo)
                            <a href="{{ route('admin.photos.edit', $photo) }}" class="text-blue-600 text-sm">Edit</a>
                        @endcan

                        @can('delete', $photo)
                            <form method="POST" action="{{ route('admin.photos.destroy', $photo) }}">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 text-sm">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>