<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Permission;

class Role extends Model
{
  /**
   * Many to Many Relationship Role & Permission
   * A Role can have n Permissions
   * A Permission can be assigned to n Roles
   * @return mixed
   */
    public function permissions() {
      return $this->belongsToMany('App\Permission', 'roles_permissions');
    }
}
