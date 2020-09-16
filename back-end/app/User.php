<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as UserRequest;
use Laravel\Passport\HasApiTokens;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    /**
     * Many to Many Relationship User & Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','roles_users');
    }

    /**
     * One to Many Relationship User & Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * Many to Many Relationship User & Article
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function like()
    {
        return $this->belongsToMany('App\Article', 'likes');
    }

    /**
     * One to Many Relationship User & Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Many to Many Self Relationship User & User (followers)
     *
     * An User can be followed by n Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'following_id');
    }

    /**
     * Many to Many Self Relationship User & User (following)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function following()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'following_id');
    }

    /**
     * Create a new User
     *
     * @param UserRequest $request
     */
    public function createUser(UserRequest $request)
    {
        //atributos do user
        $this->name = $request->name;
        $this->email = $request->email;
        $this->password = bcrypt($request->password);
        $this->description = $request->description;
        $this->save();

        //Create an user with a default photo
        if($request->profile_picture) {
          $this->profile_picture = $request->profile_picture;
          $this->save();
        }
        else {
          $this->profile_picture = 'https://lorempixel.com/480/640/';
        }

        //always assign a registered user marker to a newly created user
        $registeredUser = Role::where('marker', 'registered-user')->first();
        $this->roles()->attach($registeredUser);
        $this->save();

        //add other roles if desired
        if($request->role) {
          $this->roles()->attach($request->role);
          $this->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     */
     public function updateUser(Request $request)
     {
       //atualiza os campos do user
       if($request->name){
          $this->name = $request->name;
       }
       if($request->email){
         $this->email = $request->email;
       }
       if($request->password){
         $this->password = bcrypt($request->password);
       }
       if($request->description){
         $this->description = $request->description;
       }
       if($request->profile_picture){
         $this->profile_picture = $request->profile_picture;
       }
       $this->save();

       //altera os roles
       if($request->role) {
         $this->roles()->attach($request->role);
         $this->save();
       }
     }

    /**
     * Function used on CheckOwnerMiddleware that check if the authenticated user is owner of the given article.
     *
     * @param $article_id
     * @return bool
     */
     public function isArticleOwner($article_id) {
       $user = Auth::user();
       return (bool) $user->articles->contains('id', $article_id);
     }

    /**
     * Function used on CheckOwnerMiddleware that check if the authenticated user is owner of the given comment.
     *
     * @param $comment_id
     * @return bool
     */
     public function isCommentOwner($comment_id) {
       $user = Auth::user();
       return (bool) $user->comments->contains('id', $comment_id);
     }
}
