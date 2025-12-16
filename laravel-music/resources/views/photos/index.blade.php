<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📸 Photo Uploads
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data" class="mb-6">
                    @csrf
                    <input type="text" name="title" placeholder="Title (optional)" class="w-full border rounded p-2 mb-2">
                    <input type="file" name="photo" accept="image/*" class="w-full border rounded p-2 mb-2">
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Upload</button>
                </form>

                <div class="grid grid-cols-2 gap-4">
                    @foreach ($photos as $photo)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $photo->path) }}" class="rounded shadow" alt="Photo">

                            <form method="POST" action="{{ route('photos.destroy', $photo) }}" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-2 py-1 rounded opacity-75 hover:opacity-100">
                                    ✖
                                </button>
                            </form>

                            @if($photo->title)
                                <p class="text-center text-sm mt-1">{{ $photo->title }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>