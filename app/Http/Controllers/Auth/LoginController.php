<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Lang, Socialite;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }


    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('front.auth.login');
    }

    protected function credentials(Request $request)
    {
      if(is_numeric($request->get('email'))){
          return ['mobile'=>$request->get('email'),'password'=>$request->get('password')];
      }
      return $request->only($this->username(), 'password');
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->to('/login')
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => Lang::get('auth.failed'),
            ]);
    }

    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('blog');
    }

    public function redirectToProvider()
    {
      return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
      try {
        $user = Socialite::driver('google')->user();
      } catch (\Exception $e) {
        return redirect('/login');
      }
      // only allow people with @company.com to login
      // if(explode("@", $user->email)[1] !== 'company.com'){
      //     return redirect()->to('/');
      // }
      // check if they're an existing user
      $existingUser = User::where('email', $user->email)->first();
      if($existingUser){        
          // log them in
          auth()->login($existingUser, true);
      } else {
          // create a new user
          $newUser                  = new User;
          $newUser->name            = $user->name;
          $newUser->email           = $user->email;
          $newUser->google_id       = $user->id;
          // $newUser->avatar          = $user->avatar;
          // $newUser->avatar_original = $user->avatar_original;
          $newUser->save();
          auth()->login($newUser, true);
      }

      return redirect()->route('blog');
    }

}
