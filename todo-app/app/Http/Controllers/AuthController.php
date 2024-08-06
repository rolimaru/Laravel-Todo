<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use function Laravel\Prompts\password;

class AuthController extends Controller
{
    //
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        return view('register');
    }
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            return response()->json(['success' => true]); // Return success response
        }

        return redirect()->back()->withErrors(['error' => 'Invalid credentials']);
    }

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);


        $data['name'] = $request->username;
        $data['email'] = $request->email;
        $data['password'] = $request->password;

        $user = User::create($data);

        if (!$user) {
            return redirect(route('register'));
        }
        // return redirect()->intended(route('todo'));
        return  "success";
    }
}
