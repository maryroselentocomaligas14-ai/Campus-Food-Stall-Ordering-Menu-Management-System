<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Menu') }}
            </h2>
            <a href="{{ route('vendor.dashboard') }}" class="text-indigo-600 hover:text-indigo-900">
                &larr; {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Add New Item Form -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">{{ __("Add New Food Item") }}</h3>
                        <form action="{{ route('vendor.menu.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Item Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="price" :value="__('Price (₱)')" />
                                <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            </div>
                            <div class="mb-4">
                                <x-input-label for="photo" :value="__('Photo')" />
                                <input type="file" id="photo" name="photo" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                            </div>
                            <x-primary-button class="w-full justify-center">{{ __('Add Item') }}</x-primary-button>
                        </form>
                    </div>
                </div>

                <!-- Menu Items List -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium mb-4">{{ __("Current Menu") }}</h3>
                        @if($menuItems->isEmpty())
                            <p class="text-gray-500 italic">{{ __("No items in your menu yet.") }}</p>
                        @else
                            <div class="space-y-4">
                                @foreach($menuItems as $item)
                                    <div class="flex items-center p-4 border rounded-lg hover:bg-gray-50 transition">
                                        @if($item->photo)
                                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg mr-4 flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h4 class="font-bold text-gray-800">{{ $item->name }}</h4>
                                                    <p class="text-sm text-gray-600">₱{{ number_format($item->price, 2) }}</p>
                                                </div>
                                                <div class="flex gap-2">
                                                    <!-- Edit Button (could be a modal in a full implementation) -->
                                                    <form action="{{ route('vendor.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="mt-2 flex items-center">
                                                <span class="text-xs {{ $item->is_available ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded-full font-medium">
                                                    {{ $item->is_available ? 'Available' : 'Unavailable' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
