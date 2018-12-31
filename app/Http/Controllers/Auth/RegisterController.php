<?php

namespace Lakeview\Http\Controllers\Auth;

use Lakeview\User;
use Illuminate\Http\Request;
use Lakeview\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account/register/confirmed';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		parent::__construct();
		//$this->pageData = new \stdClass();
        $this->middleware('guest');
    }
	
	public function register(Request $request)
    {
		//dd($request->all());
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        return $this->registered($request, $user)?: redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
			'fsUk' => ['required','string','max:255'],
			'birthday' => ['required', 'string', 'max:10', 'min:10'],
			'country' => ['required','string','max:3'],
			'timezone' => ['required','integer'],
			'english' => ['required'],
			'discord' => ['required'],
			'mic' => ['required'],
			'otherServer' => ['required'],
			'experience' => ['required'],
			'donate' => ['required'],
			'about' => ['required', 'string'],
			'whyPartOfTeam' => ['required']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Lakeview\User
     */
	
	
	
    protected function create(array $data)
    {
		$date = \DateTime::createFromFormat('d/m/Y', $data['birthday']);
		
		
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
			'fsUk' => $data['fsUk'],
			'birthday' => $date->format('Y-m-d G:i:s.u'),
			'country' => $data['country'],
			'timezone' => $data['timezone'],
			'english' =>  $data['english'] == 'on'?true:false,
			'discord' => $data['discord'] == 'on'?true:false,
			'mic' => $data['mic'] == 'on'?true:false,
			'otherServer' => $data['otherServer'] == 'on'?true:false,
			'experience' => $data['experience'] == 'on'?true:false,
			'donate' => $data['donate'] == 'on'?true:false,
			'about' => $data['about'],
			'whyPartOfTeam' => $data['whyPartOfTeam'],
        ]);
    }
	
	public function showRegistrationForm()
    {
		
		$this->pageData->activeNav = 'register';




		/* Ajax View Loading could be a possibilty in the future
		$view = (string) view()->make('auth.register',compact('activeNav'))->render();
		return $view;
		*/
		
        return view('auth.register',['pageData' => $this->pageData]);
    }
	
	public function confirmed(){
		return view('auth.registerConfirmed', ['pageData' => $this->pageData]);
	}
}
