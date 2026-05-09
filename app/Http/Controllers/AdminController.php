<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Stall;
use App\Models\Order;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stalls = Stall::with('user', 'foodItems')->get();
        $totalSales = Order::where('status', 'completed')->sum('total_price');
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $reviews = \App\Models\Review::with('user', 'order.stall')->latest()->take(20)->get();

        return view('admin.dashboard', compact('stalls', 'totalSales', 'totalOrders', 'totalUsers', 'reviews'));
    }

    public function toggleStallStatus(Stall $stall)
    {
        $stall->update(['is_active' => !$stall->is_active]);
        return back()->with('success', 'Stall status updated successfully!');
    }
}
