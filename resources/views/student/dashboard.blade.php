<x-app-layout>
    <x-slot name="header">
        <!-- Student Browsing Page -->
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Welcome to Campus Food') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">{{ __('Available Food Stalls') }}</h3>
            
            @if($stalls->isEmpty())
                <div class="bg-white p-6 rounded-lg shadow text-center">
                    <p class="text-gray-500">{{ __('No food stalls are currently active.') }}</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($stalls as $stall)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition">
                            <div class="p-6">
                                <h4 class="text-xl font-bold text-indigo-600 mb-2">{{ $stall->name }}</h4>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $stall->description }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-400">{{ $stall->foodItems->count() }} Items</span>
                                    <a href="{{ route('student.stall.show', $stall->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('View Menu') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
