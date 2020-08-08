<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Role;
use App\Permission;

class User extends Authenticatable
{
    use Notifiable;

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
        if($request->role != NULL) { //se existir um role associado
          $this->roles()->attach($request->role); //attaching o role ao user
          $this->save();
        }

        //associando uma permission ao user
        if($request->permissions != NULL) {
          foreach($request->permissions as $permission) {
            $this->permissions()->attach($permission);
            $this->save();
          }
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
       if($request->permissions) {
         foreach($request->permissions as $permission) {
           $this->permissions()->attach($request->permissions);
           $this->save();
         }
       }
     }
}
