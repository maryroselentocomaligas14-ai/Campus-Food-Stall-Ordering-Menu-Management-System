<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Food Item') }}: {{ $item->name }}
            </h2>
            <a href="{{ route('vendor.menu.index') }}" class="text-indigo-600 hover:text-indigo-900">
                &larr; {{ __('Back to Menu') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('vendor.menu.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Item Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $item->name)" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="price" :value="__('Price (₱)')" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" step="0.01" name="price" :value="old('price', $item->price)" required />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('description', $item->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="is_available" :value="__('Availability')" />
                        <div class="mt-2 flex items-center">
                            <input type="checkbox" id="is_available" name="is_available" value="1" {{ $item->is_available ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <label for="is_available" class="ml-2 text-sm text-gray-600">{{ __('Item is currently available') }}</label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="photo" :value="__('Update Photo (Optional)')" />
                        @if($item->photo)
                            <div class="mt-2 mb-4">
                                <img src="{{ asset('storage/' . $item->photo) }}" alt="Current Photo" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" id="photo" name="photo" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Update Item') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
