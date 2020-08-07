<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Role;

class Permission extends Model
{
  /**
   * Many to Many Relationship Role & Permission
   * A Role can have n Permissions
   * A Permission can be assigned to n Roles
   */
    public function roles() {
      return $this->belongsToMany('App\Role', 'roles_permissions');
    }
}
