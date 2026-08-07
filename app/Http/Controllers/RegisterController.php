<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;                  // FIX 1: Correct User model namespace
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password; // <-- Added this import

class RegisterController extends Controller
{
    public function __invoke(Request $request){
           $userData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'user_role' => ['required', 'string'],
            'password' => ['required', Password::min(8) ->mixedCase()
                                                        ->numbers()
                                                        ->symbols() ],
        ]);

        $userData['password'] = bcrypt($userData['password']);

        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
