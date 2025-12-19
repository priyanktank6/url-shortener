<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invitation;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', 'in:admin,member'],
        ]);

        $this->authorize('create', [Invitation::class, $request->role]);

        $companyId = null;

        // SuperAdmin → new company
        if (auth()->user()->role->name === 'super_admin') {
            $company = Company::create([
                'name' => 'Company ' . Str::random(5),
            ]);
            $companyId = $company->id;
        }

        // Admin → own company
        if (auth()->user()->role->name === 'admin') {
            $companyId = auth()->user()->company_id;
        }

        Invitation::create([
            'email' => $request->email,
            'company_id' => $companyId,
            'role_id' => Role::where('name', $request->role)->first()->id,
            'token' => Str::uuid(),
        ]);

        return back()->with('success', 'Invitation sent.');
    }

    public function accept(string $token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        if ($invitation->accepted_at) {
            abort(403);
        }

        return view('auth.register', [
            'email' => $invitation->email,
            'token' => $token,
        ]);
    }

    
}
