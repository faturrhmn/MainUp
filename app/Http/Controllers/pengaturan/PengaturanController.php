<?php

namespace App\Http\Controllers\pengaturan;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('content.pengaturan.index', compact('users'));
    }
} 