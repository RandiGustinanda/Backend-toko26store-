<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class adminController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'pelanggan')->get();

        return response()->json([
            'message' => 'List pelanggan',
            'data' => $customers
        ]);
    }
}
