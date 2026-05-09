<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Stall;

class StudentController extends Controller
{
    public function dashboard()
    {
        $stalls = Stall::where('is_active', true)->get();
        return view('student.dashboard', compact('stalls'));
    }

    public function showStall(Stall $stall)
    {
        $stall->load('foodItems');
        return view('student.stall-menu', compact('stall'));
    }
}
