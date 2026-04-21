<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user()->loadMissing('role.permissions');
        $permissions = $user->getPermissions()->sortBy('name')->values();

        return view('user.home', compact('user', 'permissions'));
    }
}

