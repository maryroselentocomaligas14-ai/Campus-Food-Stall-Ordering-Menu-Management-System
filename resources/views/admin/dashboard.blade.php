<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Administration') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

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
        </div>
    </div>
</x-app-layout>
