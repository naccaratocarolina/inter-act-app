<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;
use App\Permission;

class Role extends Model
{
  /**
   * Many to Many Relationship User & Role
   * A User can have n Roles
   * A Role can be assigned to n Users
   * @return mixed
   */
    public function users()
    {
        return $this->belongsToMany('App\User','roles_users');
    }

  /**
   * Many to Many Relationship Role & Permission
   * A Role can have n Permissions
   * A Permission can be assigned to n Roles
   * @return mixed
   */
    public function permissions() {
      return $this->belongsToMany('App\Permission', 'roles_permissions');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRole(Request $request)
    {
      $this->name = $request->name;
      $this->marker = $request->marker;
      $this->save();

      //cria um array de permissoes separado por virgula
      $permissionsList = explode(',', $request->roles_permissions);

      foreach($permissionsList as $permission) {
        $role_permission = new Permission();
        $role_permission->name = $permission;
        $role_permission->marker = strtolower(str_replace(" ", "-", $permission)); //cria o marker da permission separado por -
        $role_permission->save();
        $this->permissions()->attach($role_permission->id);
        $this->save();
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request)
    {
        if($request->name) {
          $this->name = $request->name;
        }
        if($request->marker) {
          $this->marker = $request->marker;
        }

        $this->save();

        //detach as permissions do role para depois alterar
        $this->permissions()->detach();

        $permissions = explode(',', $request->roles_permissions);

        foreach($permissions as $permission) {
          $permissions = new Permission();
          $permissions->name = $permission;
          $permissions->marker = strtolower(str_replace(" ", "-", $permission)); //cria o marker da permission separado por -
          $permissions->save();
          $this->permissions()->attach($permissions->id);
          $this->save();
        }

    }
}
