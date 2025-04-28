<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('content.pengaturan.index', compact('users'));
    }
} 