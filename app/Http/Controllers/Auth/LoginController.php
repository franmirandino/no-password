<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
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
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function loginRequest(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|exists:users'
        ]);

        $user = User::where('email', $request->email)->first();

        $user->update(['login_token' => str_random(60)]);

        //enviar el correo con el link del login

        return back()->withSuccess('Te hemos enviado un email con el link para el login');
    }

    public function loginWithToken(Request $request)
    {
        $user = User::where('email', $request->email)->firstOrFail();

        if(Hash::check($user->login_token, $request->token))
        {
            Auth::login($user);

            $user->update(['login_token' => null]);

            return redirect('home')->withSuccess('Has iniciado sesión correctamente');
        }

        return redirect('login')->withDanger('El token es inválido, por favor solicitelo de nuevo');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
