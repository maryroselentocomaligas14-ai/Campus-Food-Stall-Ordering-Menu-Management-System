<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                    <h4 class="text-gray-500 font-semibold mb-2 text-sm uppercase tracking-wider">{{ __('Total Sales') }}</h4>
                    <p class="text-3xl font-bold text-indigo-600">₱{{ number_format($totalSales, 2) }}</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                    <h4 class="text-gray-500 font-semibold mb-2 text-sm uppercase tracking-wider">{{ __('Total Orders') }}</h4>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                    <h4 class="text-gray-500 font-semibold mb-2 text-sm uppercase tracking-wider">{{ __('Total Stalls') }}</h4>
                    <p class="text-3xl font-bold text-gray-800">{{ $stalls->count() }}</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-sm border border-gray-100">
                    <h4 class="text-gray-500 font-semibold mb-2 text-sm uppercase tracking-wider">{{ __('Total Users') }}</h4>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
            </div>

            <!-- Stalls Management -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">{{ __('Manage Food Stalls') }}</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="p-3 border-b font-bold text-gray-600">{{ __('Stall Name') }}</th>
                                    <th class="p-3 border-b font-bold text-gray-600">{{ __('Owner') }}</th>
                                    <th class="p-3 border-b font-bold text-gray-600">{{ __('Items') }}</th>
                                    <th class="p-3 border-b font-bold text-gray-600">{{ __('Status') }}</th>
                                    <th class="p-3 border-b font-bold text-gray-600">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stalls as $stall)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="p-3 border-b">
                                            <div class="font-bold text-gray-800">{{ $stall->name }}</div>
                                            <div class="text-xs text-gray-500 line-clamp-1">{{ $stall->description }}</div>
                                        </td>
                                        <td class="p-3 border-b text-gray-600">{{ $stall->user->name }}</td>
                                        <td class="p-3 border-b text-gray-600">{{ $stall->foodItems->count() }}</td>
                                        <td class="p-3 border-b">
                                            <span class="px-2 py-1 rounded-full text-xs font-bold uppercase {{ $stall->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $stall->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="p-3 border-b">
                                            <form action="{{ route('admin.stall.toggle', $stall->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-sm font-medium {{ $stall->is_active ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900' }}">
                                                    {{ $stall->is_active ? __('Deactivate') : __('Activate') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Reviews -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('Recent Customer Reviews') }}</h3>
                    @if($reviews->isEmpty())
                        <p class="text-gray-500 italic">{{ __("No reviews yet.") }}</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($reviews as $review)
                                <div class="p-4 border rounded-lg bg-gray-50 shadow-sm">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <span class="font-bold text-gray-800">{{ $review->user->name }}</span>
                                            <p class="text-xs text-indigo-600 font-medium">{{ $review->order->stall->name }}</p>
                                        </div>
                                        <div class="flex text-yellow-400">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <p class="text-gray-600 italic text-sm mb-2">"{{ $review->comment }}"</p>
                                    <div class="text-xs text-gray-400">{{ $review->created_at->format('M d, Y') }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
