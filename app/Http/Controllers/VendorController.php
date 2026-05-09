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

            $topItems = \App\Models\OrderItem::whereHas('order', function($q) use ($stall) {
                    $q->where('stall_id', $stall->id)->where('status', 'completed');
                })
                ->select('food_item_id', \DB::raw('SUM(quantity) as total_qty'))
                ->with('foodItem')
                ->groupBy('food_item_id')
                ->orderByDesc('total_qty')
                ->take(3)
                ->get();
            
            $reviews = \App\Models\Review::whereHas('order', function($q) use ($stall) {
                $q->where('stall_id', $stall->id);
            })->with('user', 'order')->latest()->take(10)->get();
        }

        return view('vendor.dashboard', compact('stall', 'orders', 'todaySales', 'topItems', 'reviews'));
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
