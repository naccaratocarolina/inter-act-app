
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
Route::get('indexUserArticles','ArticleController@indexUserArticles');

//Passport Controller
Route::post('register', 'API\PassportController@register')->name('register');
Route::post('login', 'API\PassportController@login')->name('login');

//User Controller
Route::get('indexUser', 'UserController@indexUser');
Route::post('createUser', 'UserController@createUser');

//Role Controller
Route::post('createRole', 'RoleController@createRole');

//Comment Controller
Route::get('indexAllComment','CommentController@indexAllComment');

/*
|--------------------------------------------------------------------------
| Routes that require a logged in user
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'auth:api'], function() {
  Route::get('logout', 'API\PassportController@logout');
  Route::post('getDetails', 'API\PassportController@getDetails');

  //Article Controller
  Route::get('indexFollowingArticles', 'ArticleController@indexFollowingArticles');
  Route::get('indexArticleOwner/{id}', 'ArticleController@indexArticleOwner');
  Route::get('likesCounter/{id}', 'ArticleController@likesCounter');
  Route::post('createArticle','ArticleController@createArticle');
  Route::post('updatePhotoArticle/{id}', 'ArticleController@updatePhotoArticle');
  Route::put('updateArticle/{id}','ArticleController@updateArticle')->middleware('role');
  Route::delete('destroyArticle/{id}','ArticleController@destroyArticle')->middleware('role');
  Route::delete('detelePhotoArticle/{id}', 'ArticleController@deletePhotoArticle');

  //Comment Controller
  Route::get('indexUserComment/{user_id}','CommentController@indexUserComment');
  Route::get('indexArticleComment/{article_id}','CommentController@indexArticleComment');
  Route::get('indexCommentOwner/{id}', 'CommentController@indexCommentOwner');
  Route::get('showComment/{id}','CommentController@showComment');
  Route::post('postCommentOnArticle/{article_id}','CommentController@postCommentOnArticle');
  Route::put('updateComment/{id}','CommentController@updateComment')->middleware('owner');
  Route::delete('destroyComment/{id}','CommentController@destroyComment')->middleware('owner');

  //Role Controller
  Route::get('indexRole', 'RoleController@indexRole')->middleware('moderator');
  Route::get('showRole/{id}', 'RoleController@showRole')->middleware('moderator');
  Route::post('addRole/{role_id}', 'RoleController@addRole')->middleware('moderator');
  Route::put('updateRole/{id}', 'RoleController@updateRole')->middleware('moderator');
  Route::delete('destroyRole/{id}', 'RoleController@destroyRole')->middleware('moderator');

  //User Controller
  Route::get('showUser/{id}', 'UserController@showUser');
  Route::get('actionLike/{article_id}', 'UserController@actionLike');
  Route::get('actionFollow/{following_id}', 'UserController@actionFollow');
  Route::get('followingCounter', 'UserController@followingCounter');
  Route::get('followersCounter', 'UserController@followersCounter');
  Route::get('hasFollow/{following_id}', 'UserController@hasFollow');
  Route::get('hasLike/{article_id}', 'UserController@hasLike');
  Route::post('updatePhotoUser/{id}', 'UserController@updatePhotoUser');
  Route::put('updateUser/{id}', 'UserController@updateUser')->middleware('role');
  Route::delete('destroyUser/{id}', 'UserController@destroyUser')->middleware('role');
  Route::delete('detelePhotoUser/{id}', 'UserController@deletePhotoUser');
});
