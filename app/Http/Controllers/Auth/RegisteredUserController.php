<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invitation;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

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
        if ($request->filled('token')) {
            $invitation = Invitation::where('token', $request->token)
                ->whereNull('accepted_at')
                ->firstOrFail();

            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'confirmed'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $invitation->email,
                'password' => Hash::make($request->password),
                'role_id' => $invitation->role_id,
                'company_id' => $invitation->company_id,
            ]);

            $invitation->update(['accepted_at' => now()]);
        }
        // 🔹 DEFAULT BREEZE FLOW (tests / local only)
        else {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed'],
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => Role::firstOrCreate(['name' => 'member'])->id,
                'company_id' => Company::factory()->create()->id,
            ]);
        }

        event(new Registered($user));
        Auth::guard('web')->login($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
