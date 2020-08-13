<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as UserRequest;
use Laravel\Passport\HasApiTokens;

use App\Article;
use App\Comment;
use App\Role;

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
     * An User can have n Roles
     * A Role can be assigned to n Users
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','roles_users');
    }

    /**
     * One to Many Relationship User & Article
     * An User can have n Articles
     * A Article can belong to 1 User
     * @return mixed
     */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    /**
     * Many to Many Relationship User & Article
     * An User can like n Articles
     * A Article can be liked by n Users
     * @return mixed
     */
    public function like()
    {
        return $this->belongsToMany('App\Article', 'likes');
    }

    /**
     * One to Many Relationship User & Comment
     * An User can post n Comments
     * A Comment can belong to 1 User
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Many to Many Self Relationship User & User
     * An User can follow n Users
     * An User can be followed by n Users
     * @return mixed
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'followers', 'follower_id', 'following_id');
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'following', 'follower_id', 'following_id');
    }

    /**
     * Create a new User
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser(UserRequest $request)
    {
        //atributos do user
        $this->name = $request->name;
        $this->email = $request->email;
        $this->password = bcrypt($request->password);
        $this->profile_picture = $request->profile_picture;
        $this->description = $request->description;
        $this->save();

        //associando um role ao user
        if($request->role) {
          $this->roles()->attach($request->role);
          $this->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
       if($request->profile_picture){
         $name = $user_id->kebab_case($user->name); // nomear img sem caracter especial e associar o id
         $extenstion = $request->profile_picture->extension();
         $namePhoto = "{$name}.{$extenstion}";
         $this->profile_picture = $request->profile_picture;
        }
       if($request->description){
         $this->description = $request->description;
       }
       $this->save();

       //altera os roles
       if($request->role) {
         $this->roles()->attach($request->role);
         $this->save();
       }
     }
}


        //  $data[profile_picture] = $user->'profile_picture'; //para pegar o valor da imagem na tabela
        //  if($user->profile_picture){
          
         
        // $name = $user->profile_picture //usar o nome da propria img
        // 0}
        // else{