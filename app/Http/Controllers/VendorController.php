<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function dashboard()
    {
        $stall = auth()->user()->stall;
        $orders = [];
        $todaySales = 0;

        if ($stall) {
            $orders = \App\Models\Order::where('stall_id', $stall->id)
                ->whereIn('status', ['pending', 'preparing', 'ready'])
                ->with('user', 'orderItems.foodItem')
                ->latest()
                ->get();
            
            $todaySales = \App\Models\Order::where('stall_id', $stall->id)
                ->where('status', 'completed')
                ->whereDate('created_at', now()->today())
                ->sum('total_price');
        }

        return view('vendor.dashboard', compact('stall', 'orders', 'todaySales'));
    }

    public function updateOrderStatus(Request $request, \App\Models\Order $order)
    {
        if ($order->stall_id !== auth()->user()->stall->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully!');
    }

    public function createStall(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        auth()->user()->stall()->create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Stall created successfully!');
    }
}
