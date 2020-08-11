<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Notification\toMail;
use App\Role;
use App\Permission;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

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
     * Many to Many Relationship User & Permission
     * A User can have n Permissions
     * A Permission can be assigned to n User
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission','permissions_users');
    }

    /**
     * Create a new User
     *
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        //atributos do user
        $this->name = $request->name;
        $this->email = $request->email;
        $this->password = bcrypt($request->password);
        $this->save();

        //associando um role ao user
        if($request->role) {
          $this->roles()->attach($request->role);
          $this->save();
        }

        if($request->permission) {
          $this->permissions()->attach($request->permission);
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
       $this->save();

       //detach os roles e permissions do user para depois alterar
       $this->roles()->detach();
       $this->permissions()->detach();

       //altera os roles
       if($request->role) {
         $this->roles()->attach($request->role);
         $this->save();
       }

       //altera as permissions
       if($request->permission) {
         $this->permissions()->attach($request->permission);
         $this->save();
       }
     }

     /**
      * Check if the user has a role assigned
      * @return bool
      */
     public function hasRole($roles)
     {
       //receives an array of roles and checks if the user is associated
       foreach($roles as $role) {
         if($this->roles->contains('marker', $role)) {
           return true; //if yes, returns true
         }
       }
       return false; //if no, returns false
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
}
