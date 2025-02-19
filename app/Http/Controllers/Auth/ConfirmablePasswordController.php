<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {

        
        if (! Auth::guard('web')->validate([
            'username' => $request->user()->username,
            'password' => $request->password,
            'sisterconcern_id' => $request->sisterconcern_id,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }
        
        
        $request->session()->put('auth.password_confirmed_at', time());
        


        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
