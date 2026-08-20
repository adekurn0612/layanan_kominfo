<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register', [
            'organizations' => Organization::where('is_active', true)->orderBy('name')->get(),
        ]);
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->safe()->except(['password_confirmation']) + ['is_active' => false]);

        event(new Registered($user));

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil. Akun Anda menunggu verifikasi admin.');
    }
}
