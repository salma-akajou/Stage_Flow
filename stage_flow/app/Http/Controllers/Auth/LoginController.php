<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    |*/

    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $role = Auth::user()->getRoleNames()->first();
        
        return match ($role) {
            'admin'      => '/admin/dashboard',
            'moderateur' => '/admin/dashboard',
            'etudiant'   => '/student/dashboard',
            'entreprise' => '/entreprise/dashboard',
            default      => '/home',
        };
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function loggedOut($request)
    {
        return redirect()->route('login');
    }

    /**
     * L'utilisateur a été authentifié.
     */
    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if ($user->statut !== 'actif') {
            Auth::logout();
            return redirect()->route('login')
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([$this->username() => 'Votre compte est suspendu. Veuillez contacter l\'administration.']);
        }

        return redirect()->intended($this->redirectPath());
    }
}
