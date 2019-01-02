<?php

namespace Lakeview\Http\Controllers\Auth;

use Lakeview\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();
        $this->middleware('guest')->except('logout');
    }
	
	
	
	public function showLoginForm()
    {
		
		$this->pageData->activeNav = 'login';
        return view('auth.login',['pageData' => $this->pageData]);
    }
	
	public function login(Request $request)
    {
        return $this->authenticate($request);
    }
	
	public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
		$credentials['member'] = 1;
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }
		else{
			return back()->withInput($request->only('email','remember'))->withErrors(['email' => "Login Failed, Check your Username or Password. If this is the first time you're logging in your account many not be active yet"]);
		}
    }
}
