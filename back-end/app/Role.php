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
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User','roles_users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param RoleRequest $request
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
     * @param RoleRequest $request
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
