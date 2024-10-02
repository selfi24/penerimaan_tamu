<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Mews\Captcha\Facades\Captcha;

use Illuminate\Support\Facades\Redirect;

class CaptchaController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Ensure this view file exists
    }

    /**
     * Handle the login request with CAPTCHA validation.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function captchaValidate(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
            'captcha' => 'required|captcha'
        ]);
    
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check user type and redirect accordingly
            switch ($user->usertype) {
                case 'user':
                    return redirect()->route('home');
                case 'admin':
                    return redirect()->route('index');
                case 'superadmin':
                    return redirect()->route('superadmin.index');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Tipe pengguna tidak valid.');
            }
        }

        // Authentication failed
        return redirect()->back()->withErrors([
            'email' => 'Email atau password tidak valid.'
        ])->withInput($request->except('password'));
    }

    /**
     * Refresh CAPTCHA image.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

  
public function authenticated(Request $request, $user)
{
    // Assuming the user has an opd_id field
    session(['opd_id' => $user->opd_id]);
}

}