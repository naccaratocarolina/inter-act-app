<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Role;

class Permission extends Model
{
  /**
   * Many to Many Relationship User & Permission
   * A User can have n Permissions
   * A Permission can be assigned to n User
   * @return mixed
   */
  public function users()
  {
      return $this->belongsToMany('App\User','permissions_users');
  }
  
  /**
   * Many to Many Relationship Role & Permission
   * A Role can have n Permissions
   * A Permission can be assigned to n Roles
   * @return mixed
   */
    public function roles() {
      return $this->belongsToMany('App\Role', 'roles_permissions');
    }
}
