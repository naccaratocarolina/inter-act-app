<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Requests\RoleRequest as RoleRequest;

use App\User;
use Auth;

class Role extends Model
{
  /**
   * Many to Many Relationship User & Role
   * An User can have n Roles
   * A Role can be assigned to n Users
   * @return mixed
   */
    public function users()
    {
        return $this->belongsToMany('App\User','roles_users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRole(RoleRequest $request)
    {
        $this->name = $request->name;
        $this->marker = $request->marker;
        $this->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function updateRole(RoleRequest $request)
    {
        if($request->name) {
          $this->name = $request->name;
        }
        if($request->marker) {
          $this->marker = $request->marker;
        }

        $this->save();
    }
}
