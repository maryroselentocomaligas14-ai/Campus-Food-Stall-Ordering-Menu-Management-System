<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FoodItemController extends Controller
{
    public function index()
    {
        $stall = auth()->user()->stall;
        $menuItems = $stall->foodItems;
        return view('vendor.menu.index', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('photo');
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('food_photos', 'public');
        }

        auth()->user()->stall->foodItems()->create($data);

        return back()->with('success', 'Food item added successfully!');
    }

    public function update(Request $request, $id)
    {
        $item = auth()->user()->stall->foodItems()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['photo', 'is_available']);
        $data['is_available'] = $request->has('is_available');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('food_photos', 'public');
        }

        $item->update($data);

        return back()->with('success', 'Food item updated successfully!');
    }

    public function destroy($id)
    {
        $item = auth()->user()->stall->foodItems()->findOrFail($id);
        $item->delete();
        return back()->with('success', 'Food item deleted successfully!');
    }
}
