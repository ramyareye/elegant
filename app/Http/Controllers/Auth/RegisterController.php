<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth; 

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
    protected $redirectTo = '/blog';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
      
        $messages = array(
          'name.required' => 'نام را وارد کنید',
          'name.string' => 'نام را وارد کنید',
          'name.max' => 'طول نام زیاد است',
          'family.required' => 'نام‌خانوادگی را وارد کنید',
          'family.string' => 'نام‌خانوادگی را وارد کنید',
          'family.max' => 'نام‌خانوادگی صحیح نیست',
          'email.string' => 'ایمیل صحیح نیست',
          'email.email' => 'ایمیل صحیح نیست',
          'email.max' => 'ایمیل صحیح نیست',
          'email.unique' => 'از این ایمیل قبلا استفاده شده',
          'mobile.required' => 'موبایل را وارد کنید',
          'mobile.string' => 'موبایل را وارد کنید',
          'mobile.min' => 'موبایل صحیح نیست',
          'mobile.max' => 'موبایل صحیح نیست',
          'mobile.unique' => 'این موبایل پیش از این ثبت شده',
          'password.required' => 'رمز عبور را وارد کنید',
          'password.string' => 'رمز عبور صحیح نیست',
          'password.min' => 'رمز عبور را وارد کنید',
          'password.confirmed' => 'رمز عبور و تایید یکسان نیست'
        );

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'family' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'mobile' => ['required', 'string', 'min:10', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {            
      $u = [
        'name' => $data['name'],
        'family' => $data['family'],
        'mobile' => $data['mobile'],
        'type' => $data['type'],
        'week' => $data['week'],
        'send_articles' => $data['articles'],
        'contact_type_email' => $data['contact_type_email'],
        'contact_type_phone' => $data['contact_type_phone'],
        'password' => Hash::make($data['password']),
      ];

      if (isset($data['email'])) {
        $u['email'] = $data['email'];
      }

      $user = User::create($data);

      Auth::login($user);

      return $user;
    }

    public function showRegistrationForm()
    {
        return view('front.auth.register');
    }
}
