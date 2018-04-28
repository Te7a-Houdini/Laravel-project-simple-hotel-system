<?php

namespace App\Http\Controllers\Auth;

use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use \Cache;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        $countries=countries();
        Cache::forever('chachedcountry', $countries);
        $countries=Cache::get( 'chachedcountry' );

        return view('auth.register',compact('countries'));




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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'country'=>'required' ,
            'gender'=>'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
       $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'gender' => $data['gender'],//added diaa branch
            'country' => $data['country'],//added diaa branch
            'password' => Hash::make($data['password']),
        ]);

    return $user ;

        
    }


    protected function registered(Request $request, $user)
    {



        if($request->file('image')) {

            $request->file('image')->store('public/clients/images');
            // save image name in data base
            $name = $request->file('image')->hashName();
            $user->avatar_image = $name;


        }

        else
        {
            $user['avatar_image']='user-default.png';

        }
        // set role client
        $user->assignRole('client');

        $user->save();

    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }





}
