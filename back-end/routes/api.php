
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
|--------------------------------------------------------------------------
| Routes that do not need permissions
|--------------------------------------------------------------------------
*/
  //Article Controller
  Route::get('indexAllArticles','ArticleController@indexAllArticles');
  Route::get('showArticle/{id}', 'ArticleController@showArticle');
  Route::get('indexArticleOwner/{id}', 'ArticleController@indexArticleOwner');
  Route::get('indexUserArticles/{id}','ArticleController@indexUserArticles');

  //Passport Controller
  Route::post('register', 'API\PassportController@register')->name('register');
  Route::post('login', 'API\PassportController@login')->name('login');

  //User Controller
  Route::get('indexAllUsers', 'UserController@indexAllUsers');
  Route::post('createUser', 'UserController@createUser');
  Route::get('showUser/{id}', 'UserController@showUser');
  Route::get('indexFollowingUsers/{user_id}', 'UserController@indexFollowingUsers');
  Route::get('indexFollowersUsers/{user_id}', 'UserController@indexFollowersUsers');
  Route::put('updateUser/{id}', 'UserController@updateUser');
  Route::delete('destroyUser/{id}', 'UserController@destroyUser');

  //Role Controller
  Route::post('createRole', 'RoleController@createRole');

  //Comment Controller
  Route::get('indexAllComment','CommentController@indexAllComment');
  Route::get('indexArticleComment/{article_id}','CommentController@indexArticleComment');
  Route::get('indexCommentOwner/{id}', 'CommentController@indexCommentOwner');

/*
|--------------------------------------------------------------------------
| Routes that require a logged in user
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:api'], function() {
  Route::get('logout', 'API\PassportController@logout');
  Route::get('getDetails', 'API\PassportController@getDetails');

  //Article Controller
  Route::get('indexFollowingArticles', 'ArticleController@indexFollowingArticles');
  Route::post('createArticle','ArticleController@createArticle');
  Route::put('updateArticle/{id}','ArticleController@updateArticle')->middleware('owner');
  Route::delete('destroyArticle/{id}','ArticleController@destroyArticle')->middleware('owner');

  //Comment Controller
  Route::get('indexUserComment/{user_id}','CommentController@indexUserComment');
  Route::get('showComment/{id}','CommentController@showComment');
  Route::post('postCommentOnArticle/{article_id}','CommentController@postCommentOnArticle');
  Route::put('updateComment/{id}','CommentController@updateComment')->middleware('owner');
  Route::delete('destroyComment/{id}','CommentController@destroyComment')->middleware('owner');

  //Role Controller
  Route::get('indexRole', 'RoleController@indexRole')->middleware('moderator');
  Route::get('showRole/{id}', 'RoleController@showRole')->middleware('moderator');
  Route::get('addRole/{role_id}', 'RoleController@addRole')->middleware('moderator');
  Route::get('assignModerator/{user_id}', 'RoleController@assignModerator')->middleware('moderator');
  Route::put('updateRole/{id}', 'RoleController@updateRole')->middleware('moderator');
  Route::delete('destroyRole/{id}', 'RoleController@destroyRole')->middleware('moderator');

  //User Controller
  Route::get('actionLike/{article_id}', 'UserController@actionLike');
  Route::get('actionFollow/{following_id}', 'UserController@actionFollow');
  Route::get('removeFollow/{following_id}', 'UserController@removeFollow');
  Route::get('hasFollow/{following_id}', 'UserController@hasFollow');
  Route::get('hasLike/{article_id}', 'UserController@hasLike');
  Route::get('isModerator/{id}', 'UserController@isModerator');
  //Route::put('updateUser/{id}', 'UserController@updateUser')->middleware('role');
  //Route::delete('destroyUser/{id}', 'UserController@destroyUser')->middleware('role');
});
