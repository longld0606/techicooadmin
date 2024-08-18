<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends AdminController
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // neu dang la end user => logout
        // $this->middleware('auth:web')->except('logout'); 
        // $this->middleware('auth:web')->except('logout'); 
    }
    public function loginForm()
    {
        return view('admin.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            $user = Auth::guard('admin')->user();
            // cho login FE luoon
            Auth::guard('web')->attempt(array('email' => $input['email'], 'password' => $input['password']));
            if ($user) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->back()->withInput()->withErrors(['Tài khoản không hợp lệ vui lòng thử lại.']);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['Email hoặc mật khẩu không chính xác']);
        }
    }
    public function logout(Request $request)
    {          
        session()->forget('budvar_access_token');
        Auth::logout();
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
