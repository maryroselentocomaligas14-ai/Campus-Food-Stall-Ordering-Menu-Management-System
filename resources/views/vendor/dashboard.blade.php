<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vendor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

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
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
