<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Get all the profile.
     */
    public function index($role = null)
    {
        $query = User::query();

        if ($role) {
            $query->where('role', '=', $role);
        } else {
            $query->where('role', '=', 'User');
        }

        $users = $query->get();

        return view('user.users', [
            'users' => $users,
            'role' => $role
        ]);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // Converti la data nel formato corretto (YYYY-MM-DD)
        $validatedData['dob'] = Carbon::createFromFormat('d/m/Y', $validatedData['dob'])->format('Y-m-d');

        $request->user()->fill($validatedData);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update the user's account from an Admin.
     */
    public function updateFromAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'role' => ['required', 'string', 'in:Admin,Evaluator,User'],
            'company_role' => ['required', 'string', 'max:255'],
        ]);

        $user = User::findOrFail($request->id);

        if ($request->email !== $user->email) {
            if (User::where('email', $request->email)->exists()) {
                return redirect()->back()->withErrors(['email' => 'This email is already in use.'])->withInput();
            }
        }

        $user->update($validatedData);

        return redirect()->route('users')->with('success', 'User updated successfully!');
    }

    /**
     * Delete the user's account from an Admin.
     */
    public function destroyFromAdmin(Request $request, $id): RedirectResponse
    {
        // Verifica se l'utente autenticato è un amministratore
        if (!$request->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $userToDelete = User::findOrFail($id);

        $userToDelete->delete();

        // Redirect alla pagina desiderata
        return Redirect::route('users')->with('success', 'User deleted successfully!');
    }
}
