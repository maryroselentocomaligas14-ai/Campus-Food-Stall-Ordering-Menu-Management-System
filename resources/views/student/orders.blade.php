<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="space-y-6">
                @forelse($orders as $order)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $order->stall->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-xs text-gray-400 uppercase tracking-widest">{{ __('Queue Number') }}</p>
                                        <p class="text-2xl font-black text-indigo-600">{{ $order->queue_number }}</p>
                                    </div>
                                    <div class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($order->status == 'preparing') bg-blue-100 text-blue-700
                                        @elseif($order->status == 'ready') bg-green-100 text-green-700
                                        @elseif($order->status == 'completed') bg-gray-100 text-gray-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ $order->status }}
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="flex items-center">
                                            <span class="w-8 h-8 bg-gray-50 rounded flex items-center justify-center text-xs font-bold text-gray-500 mr-3">{{ $item->quantity }}x</span>
                                            <span class="text-gray-700 font-medium">{{ $item->foodItem->name }}</span>
                                        </div>
                                        <span class="text-gray-900 font-bold">₱{{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-100 mt-4 pt-4 flex justify-between items-center">
                                <span class="text-gray-600 font-medium">{{ __('Total Amount') }}</span>
                                <span class="text-2xl font-bold text-gray-900">₱{{ number_format($order->total_price, 2) }}</span>
                            </div>

                            @if($order->status == 'completed' && !$order->review)
                                <div class="mt-6 p-4 bg-indigo-50 rounded-lg">
                                    <h4 class="font-bold text-indigo-800 mb-2">{{ __('How was your meal?') }}</h4>
                                    <form action="{{ route('student.order.review', $order->id) }}" method="POST">
                                        @csrf
                                        <div class="flex items-center gap-4 mb-3">
                                            <select name="rating" class="text-sm rounded-md border-gray-300">
                                                <option value="5">5 - Excellent</option>
                                                <option value="4">4 - Good</option>
                                                <option value="3">3 - Average</option>
                                                <option value="2">2 - Poor</option>
                                                <option value="1">1 - Terrible</option>
                                            </select>
                                            <input type="text" name="comment" placeholder="Add a comment (optional)" class="flex-1 text-sm rounded-md border-gray-300">
                                            <x-primary-button class="text-xs">{{ __('Submit') }}</x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            @elseif($order->review)
                                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                    <div class="flex items-center gap-2">
                                        <span class="text-yellow-500 font-bold">{{ str_repeat('★', $order->review->rating) }}</span>
                                        <p class="text-gray-600 italic text-sm">"{{ $order->review->comment }}"</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 rounded-lg shadow text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ __('No orders yet') }}</h3>
                        <p class="text-gray-500 mb-6">{{ __('Explore the stalls and place your first pre-order!') }}</p>
                        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            {{ __('Browse Food Stalls') }}
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
