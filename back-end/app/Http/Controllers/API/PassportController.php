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
  public function register(UserRequest $request) {
    $user = new User;
    $user->name = $request->name;
    $user->email = $request->email;
    $user->password = bcrypt($request->password);
    $user->save();
    //always assign a registered user marker to a newly created user
    $registeredUser = Role::where('marker', 'registered-user')->first();
    $user->roles()->attach($registeredUser);
    $user->save();
    //notification of cadastre
    $user->notify(new CadastreNotification());
    $articles = $user->articles;
    $comments = $user->comments;
    $token = $user->createToken('MyApp')->accessToken;
    return response()->json([
      "message" => "Seja bem-vindx!",
      "data" => [
        "user" => $user,
        "articles" => $articles,
        "comments" => $comments,
        "token" => $token]
      ], 200);
  }

  public function login() {
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
      $user = Auth::user();
      $token = $user->createToken('MyApp')->accessToken;
      $articles = $user->articles;
      $comments = $user->comments;
      return response()->json([
        "message" => "Login concluido!",
        "data" => [
          "user" => $user,
          "articles" => $articles,
          "comments" => $comments,
          "token" => $token]
        ], 200);
    }
    else {
      return response()->json(["message" => "Email ou senha inválidos!", "data" => [null]], 500);
    }
  }

  public function getDetails() {
    $user = Auth::user();
    return response()->json(["user" => $user], 200);
  }

  public function logout() {
    $accessToken = Auth::user()->token();
    DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->update(['revoked' => true]);
    $accessToken->revoke();
    return response()->json(["User deslogado!"], 200);
  }
}
