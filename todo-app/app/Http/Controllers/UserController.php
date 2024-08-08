<?php

namespace App\Http\Controllers;

use App\Models\TodoModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


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

    public function admin()
    {
        $user = User::with('todos')->get();
        // $todo = TodoModel::all();

        return view('admin.admin', ['users' => $user]);
    }
}
