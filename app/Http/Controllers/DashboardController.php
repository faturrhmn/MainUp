<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $assets = Asset::with('room')->get();
        return view('content.dashboard.index', compact('assets'));
    }
} 