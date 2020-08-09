<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as UserRequest;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\Article;
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
    if($request->role) {
      $user->roles()->attach($request->role);
      $user->save();
    }
    $token = $user->createToken('MyApp')->accessToken;
    return response()->json(["message" => "Cadastro realizado!", "data" => ["user" => $user, "token" => $token]], 200);
  }

  public function login() {
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
      $user = Auth::user();
      $token = $user->createToken('MyApp')->accessToken;
      return response()->json(["message" => "Login realizado!", "data" => ["user" => $user, "token" => $token]], 200);
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

  public function createArticle(Request $request)
  {
      $user = Auth::user();
      if($user) {
        $article = new Article;
        $article->title = $request->title;
        $article->description = $request->description;
        $article->image = $request->image;
        $article->category = $request->category;
        $article->date = $request->date;
        $article->user_id = $request->user_id;
        $article->save();
        return response()->json(['message' => 'Artigo criado!']);
      }
  }
}
