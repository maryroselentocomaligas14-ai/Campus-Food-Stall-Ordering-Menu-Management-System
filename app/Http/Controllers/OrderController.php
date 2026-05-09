<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\FoodItem;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->with('stall', 'orderItems.foodItem')->latest()->get();
        return view('student.orders', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'food_item_id' => 'required|exists:food_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $foodItem = FoodItem::findOrFail($request->food_item_id);
        $stall = $foodItem->stall;

        // Generate queue number (e.g., KFC-001)
        $prefix = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $stall->name), 0, 3));
        $count = Order::where('stall_id', $stall->id)->count() + 1;
        $queueNumber = $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $order = Order::create([
            'user_id' => auth()->id(),
            'stall_id' => $stall->id,
            'queue_number' => $queueNumber,
            'total_price' => $foodItem->price * $request->quantity,
            'status' => 'pending',
        ]);

        $order->orderItems()->create([
            'food_item_id' => $foodItem->id,
            'quantity' => $request->quantity,
            'price' => $foodItem->price,
        ]);

        return redirect()->route('student.orders')->with('success', 'Order placed successfully! Your queue number is ' . $queueNumber);
    }
}
