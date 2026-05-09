<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(!$stall)
                        <h3 class="text-lg font-medium mb-4">{{ __("Create Your Food Stall") }}</h3>
                        <form action="{{ route('vendor.stall.create') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <x-input-label for="name" :value="__('Stall Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" required />
                            </div>
                            <div class="mb-4">
                                <x-input-label for="description" :value="__('Description')" />
                                <textarea id="description" name="description" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                            </div>
                            <x-primary-button>{{ __('Create Stall') }}</x-primary-button>
                        </form>
                    @else
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $stall->name }}</h3>
                                <p class="text-gray-600">{{ $stall->description }}</p>
                            </div>
                            <div class="flex gap-4">
                                <a href="{{ route('vendor.menu.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Manage Menu') }}
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                            <div class="p-6 bg-indigo-50 rounded-xl border border-indigo-100">
                                <h4 class="text-indigo-600 font-semibold mb-2">{{ __('Total Items') }}</h4>
                                <p class="text-3xl font-bold text-indigo-900">{{ $stall->foodItems->count() }}</p>
                            </div>
                            <div class="p-6 bg-green-50 rounded-xl border border-green-100">
                                <h4 class="text-green-600 font-semibold mb-2">{{ __('Active Orders') }}</h4>
                                <p class="text-3xl font-bold text-green-900">{{ $orders->count() }}</p>
                            </div>
                            <div class="p-6 bg-yellow-50 rounded-xl border border-yellow-100">
                                <h4 class="text-yellow-600 font-semibold mb-2">{{ __('Today\'s Sales') }}</h4>
                                <p class="text-3xl font-bold text-yellow-900">₱{{ number_format($todaySales, 2) }}</p>
                            </div>
                        </div>

                        <div class="mt-12">
                            <h3 class="text-xl font-bold text-gray-800 mb-6">{{ __('Active Orders') }}</h3>
                            @if($orders->isEmpty())
                                <p class="text-gray-500 italic">{{ __("No active orders at the moment.") }}</p>
                            @else
                                <div class="space-y-4">
                                    @foreach($orders as $order)
                                        <div class="p-4 border rounded-lg bg-gray-50 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="text-lg font-black text-indigo-600">{{ $order->queue_number }}</span>
                                                    <span class="text-gray-400">|</span>
                                                    <span class="font-bold text-gray-800">{{ $order->user->name }}</span>
                                                </div>
                                                <div class="text-sm text-gray-600">
                                                    @foreach($order->orderItems as $item)
                                                        {{ $item->quantity }}x {{ $item->foodItem->name }}{{ !$loop->last ? ',' : '' }}
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('vendor.order.status', $order->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="status" onchange="this.form.submit()" class="text-sm rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                                        <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        @if($topItems->isNotEmpty())
                            <div class="mt-12">
                                <h3 class="text-xl font-bold text-gray-800 mb-6">{{ __('Top Selling Items') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach($topItems as $item)
                                        <div class="p-4 bg-white border rounded-lg shadow-sm flex items-center justify-between">
                                            <div>
                                                <p class="font-bold text-gray-800">{{ $item->foodItem->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $item->total_qty }} {{ __('sold') }}</p>
                                            </div>
                                            <span class="text-indigo-600">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path></svg>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($reviews->isNotEmpty())
                            <div class="mt-12">
                                <h3 class="text-xl font-bold text-gray-800 mb-6">{{ __('Recent Customer Feedback') }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @foreach($reviews as $review)
                                        <div class="p-4 border rounded-lg bg-gray-50 shadow-sm">
                                            <div class="flex justify-between items-start mb-2">
                                                <div>
                                                    <span class="font-bold text-gray-800">{{ $review->user->name }}</span>
                                                    <span class="text-gray-400 text-xs ml-2">{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                                <div class="flex text-yellow-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-gray-600 italic text-sm">"{{ $review->comment }}"</p>
                                            <div class="mt-2 text-xs text-indigo-600 font-medium">
                                                Order: {{ $review->order->queue_number }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
