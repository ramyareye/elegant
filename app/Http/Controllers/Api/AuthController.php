<?php

namespace App\Http\Controllers\Api;

use App\Entities\User;
use Illuminate\Http\Request;
use DB, Hash, Validator, Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    
  protected $model;

  public function __construct(User $model)
  {
    $this->model = $model;
  }

  public function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:8|confirmed',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = $this->model->create($request->all());
    $user->assignRole('Customer');
    
    return response()->json(['status' => 201]);
    // return $this->response->created(url('api/users/'.$user->uuid));
  }

  public function login()
  {
    $email = request('email');
    // Check if a user with the specified email exists
    // $user = User::whereEmail(request('email'))->first();
    //               dd($user->toArray());
    // if (!$user) {
    //   return response()->json([
    //     'message' => 'Wrong email or password',
    //     'status' => 422
    //   ], 422);
    // }
    
    // If a user with the email was found - check if the specified password
    // belongs to this user

    // if (!Hash::check(request('password'), $user->password)) {
    if (
      !Auth::attempt(['email' => request('email'), 'password' => request('password')])
    ) {
      return response()->json([
        'message' => 'Wrong email or password',
        'status' => 422
      ], 422);
    }
    
    // Send an internal API request to get an access token
    $data = [
      'grant_type' => 'password',
      'client_id' => '2',
      'client_secret' => config('app.passport'),
      'username' => request('email'),
      'password' => request('password'),
    ];


    $request = Request::create('/oauth/token', 'POST', $data);

    $response = app()->handle($request);

    // Check if the request was successful
    if ($response->getStatusCode() != 200) {
        return response()->json([
            'message' => 'Wrong email or password',
            'status' => 422
        ], 422);
    }

    // Get the data from the response
    $data = json_decode($response->getContent());

    $userData = app('App\Http\Controllers\Api\Users\UsersController')
                  ->showByEmail($email);

    // Format the final response in a desirable format
    return response()->json([
        'token' => $data->access_token,
        'user' => $userData->original,
        'status' => 200
    ]);
  }

  public function logout()
  {
    $accessToken = auth()->user()->token();

    $refreshToken = DB::table('oauth_refresh_tokens')
      ->where('access_token_id', $accessToken->id)
      ->update([
          'revoked' => true
      ]);

    $accessToken->revoke();

    return response()->json(['status' => 200]);
  }

}
