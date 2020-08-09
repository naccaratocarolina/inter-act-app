<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as UserRequest;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

use App\Role;
use Auth;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
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
     * A User can have n Roles
     * A Role can be assigned to n Users
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role','roles_users');
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
         $this->profile_picture = $request->profile_picture;
       }
       if($request->description){
         $this->description = $request->description;
       }
       $this->save();

       //detach os roles do user para depois alterar
       $this->roles()->detach();

       //altera os roles
       if($request->role) {
         $this->roles()->attach($request->role);
         $this->save();
       }
     }

     /**
      * Check if the user has a role assigned
      * @return bool
      */
     public function hasRole($id, Role $role)
     {/*
       $user = User:findOrFail($id);
       //receives an array of roles and checks if the user is associated
       if($user->roles->contains('marker', $role)) {
         return true; //if yes, returns true
       }
       return false; //if no, returns false*/
       //return $user->roles->contains('marker', $role);
       if( strpos($role, ',') !== false ){//check if this is an list of roles

            $listOfRoles = explode(',',$role);

            foreach ($listOfRoles as $role) {
                if ($this->roles->contains('marker', $role)) {
                    return true;
                }
            }
        }else{
            if ($this->roles->contains('marker', $role)) {
                return true;
            }
        }

        return false;
     }

     /**
      * Check if the user is a moderator
      * @return bool
      */
     public function isModerator()
     {
       if($this->roles->contains('marker', 'moderator')) {
         return true;
       }
     }

     /**
      * Check if the user is a registered
      * @return bool
      */
     public function isRegisteredUser()
     {
       if($this->roles->contains('marker', 'registered-user')) {
         return true;
       }
     }
}
