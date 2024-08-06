<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getUserName()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Get the user's name
        $userName = $user->name; // Adjust if the column is named differently

        return view('example', ['userName' => $userName]);
    }
}
