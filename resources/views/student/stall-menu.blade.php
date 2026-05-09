<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $stall->name }} - {{ __('Menu') }}
            </h2>
            <a href="{{ route('student.dashboard') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">
                &larr; {{ __('Back to Stalls') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <p class="text-gray-600 text-lg">{{ $stall->description }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($stall->foodItems as $item)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col sm:flex-row gap-6">
                        @if($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-full sm:w-32 h-32 object-cover rounded-xl">
                        @else
                            <div class="w-full sm:w-32 h-32 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        
                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="text-xl font-bold text-gray-800 mb-1">{{ $item->name }}</h4>
                                <p class="text-gray-600 text-sm mb-4">{{ $item->description }}</p>
                                <p class="text-2xl font-bold text-indigo-600">₱{{ number_format($item->price, 2) }}</p>
                            </div>
                            
                            <div class="mt-4">
                                @if($item->is_available)
                                    <form action="{{ route('student.order.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="food_item_id" value="{{ $item->id }}">
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="quantity" value="1" min="1" class="w-20 rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                            <x-primary-button class="flex-1 justify-center">{{ __('Order Now') }}</x-primary-button>
                                        </div>
                                    </form>
                                @else
                                    <button disabled class="w-full py-2 bg-gray-100 text-gray-400 rounded-md font-semibold text-xs uppercase tracking-widest cursor-not-allowed">
                                        {{ __('Currently Unavailable') }}
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
