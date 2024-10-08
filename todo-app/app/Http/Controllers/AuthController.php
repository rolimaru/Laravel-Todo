<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
            $user = Auth::user();

            if ($user->role == 'admin') {
                // return redirect('/admin');
                return response()->json(['role' => 'admin']); // Return success response

            }
            return response()->json(['role' => 'user']); // Return success response
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
        $data['role'] = 'user';

        $user = User::create($data);

        if (!$user) {
            return redirect(route('register'));
        }
        // return redirect()->intended(route('todo'));
        return  "success";
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Log out the user

        $request->session()->invalidate(); // Invalidate the session

        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return redirect('/login'); // Redirect to the login page
    }
}
