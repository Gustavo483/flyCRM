<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Constant\LoginConstant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        $dataDeHoje = Carbon::now();

        $user->update([
            'dt_ultimoLogin'=>$dataDeHoje->format('Y-m-d'),
        ]);

        $permisionAccess = auth()->user()->int_permisionAccess;
        switch ($permisionAccess) {
            case LoginConstant::AdminRoot:
                return redirect()->route('dashboardAdmin');

            case LoginConstant::AdminUser:
                return redirect()->route('dashboardAdminUser');

            case LoginConstant::User:
                return redirect()->route('dashboarUser');
        }
    }

    /**
     * @return void
     */
    public function validatePermission()
    {
        $permisionAccess = auth()->user()->int_permisionAccess;
        switch ($permisionAccess) {
            case LoginConstant::AdminRoot:
                return redirect()->route('dashboardAdmin');

            case LoginConstant::AdminUser:
                return redirect()->route('dashboardAdminUser');

            case LoginConstant::User:
                return redirect()->route('dashboarUser');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
