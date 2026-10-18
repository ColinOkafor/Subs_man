<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\User;                  // FIX 1: Correct User model namespace
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password; // <-- Added this import


class RegisterController extends Controller
{
    /**
     * Handle the incoming registration request.
     * Invokable controllers have a single main action, mapped directly to a route.
     */
    public function __invoke(Request $request){
        // 1. Validate the incoming request data against strict rules
           $userData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', Password::min(8) ->mixedCase()
                                                        ->numbers()
                                                        ->symbols() ],
        ]);
        // 2. Securely hash the password before saving it to the database
        $userData['password'] = bcrypt($userData['password']);

        // 3. Create the new user record in the database using mass assignment
        $user = User::create($userData);

        // 4. Automatically log the newly registered user into the application
        Auth::login($user);

        // 5. Redirect the user to their dashboard page
        return redirect()->route('subscriptions.index');
    }

    /**
     * Handle the account deletion request.
     */
    public function destroy(Request $request)
    {
        // Retrieve the currently authenticated user instance
        $user = $request->user();

        // 1. Log the user out FIRST
        Auth::logout();

        // 2. Delete the user record
        $user->delete();

        // 3. Destroy the session entirely to prevent lingering data
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Account permanently deleted.');
    }
}
