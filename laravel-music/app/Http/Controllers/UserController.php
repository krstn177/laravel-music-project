<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
        }

        $query->orderBy('is_admin', 'desc')->orderBy('name', 'asc');

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Update the admin status of a user.
     */
    public function updateAdminStatus(User $user, Request $request)
    {
        $validated = $request->validate([
            'is_admin' => 'required|boolean',
        ]);

        $user->update($validated);

        $status = $validated['is_admin'] ? 'promoted to admin' : 'demoted from admin';
        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} has been {$status}");
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user)
    {
        // Prevent deleting the currently logged-in user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', "User {$userName} has been deleted");
    }
}