<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    // F7.1 - Admin Dashboard
    public function dashboard()
    {
        $totalUsers = User::count();
        
        $logPath = storage_path('logs/laravel.log');
        $logs = File::exists($logPath) ? File::get($logPath) : 'No logs found.';

        return view('admin.dashboard', compact('totalUsers', 'logs'));
    }

    // F7.2 - User Management
    public function users()
    {
        $users = User::paginate(15);
        return view('admin.users', compact('users'));
    }

    public function deactivateUser(User $user)
    {
        // Assuming you have a status column
        // $user->update(['status' => 'inactive']);
        return back()->with('success', 'User deactivated.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    // F7.3 - Queue Monitor
    public function queue()
    {
        return view('admin.queue');
    }
}