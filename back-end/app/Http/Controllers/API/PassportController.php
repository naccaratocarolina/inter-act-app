<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as UserRequest;
use Illuminate\Support\Facades\Validator;
use App\Notifications\CadastreNotification;

use App\User;
use App\Article;
use App\Role;
use Auth;
use DB;

class PassportController extends Controller
{
  //function that register the user
  public function register(UserRequest $request) {
    $user = new User;
    $user->createUser($request);
    //notification of cadastre
    $user->notify(new CadastreNotification());
    $token = $user->createToken('MyApp')->accessToken;
    return response()->json(["message" => "Seja bem-vindx!","data" => ["user" => $user, "token" => $token]], 200);
  }

  //function that make the login of user
  public function login() {
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
      $user = Auth::user();
      $token = $user->createToken('MyApp')->accessToken;
      return response()->json(["message" => "Login concluido!", "data" => ["user" => $user,"token" => $token]], 200);
    }
    else {
      return response()->json(["message" => "Email ou senha inválidos!", "data" => [null]], 500);
    }
  }
  //function that get more details of user
  public function getDetails() {
    $user = Auth::user();
    return response()->json(["user" => $user], 200);
  }

  //function that make the logou of user
  public function logout() {
    $accessToken = Auth::user()->token();
    DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);
    $accessToken->revoke();
    return response()->json(["User deslogado!"], 200);
  }
}
