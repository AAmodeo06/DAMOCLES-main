<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:255'],
            'dob' => ['required', 'date_format:d/m/Y'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'max:255'],
            'company_role' => ['required', 'string', 'max:255'],
        ]);

        $dateOfBirth = Carbon::createFromFormat('d/m/Y', $request->dob)->format('Y-m-d');

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'gender' => $request->gender,
            'dob' => $dateOfBirth,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,            
            'company_role' => $request->company_role,            
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Check if the user is a User 
        if ($user->role === 'User') {
            return redirect()->intended(route('questionnaires-campaign.index', absolute: false));
        } else {
            return redirect()->intended(route('dashboard', absolute: false));
        }

    }
}
