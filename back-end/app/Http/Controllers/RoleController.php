<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest as RoleRequest;

use App\User;
use Auth;

class RoleController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
    public function construct()
    {
      $this->middleware('moderator');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexRole()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return response()->json(['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRole(RoleRequest $request)
    {
      $role = new Role();
      $role->createRole($request);
      return response()->json(['role' => $role]);
    }

    /**
     * Add a role to the authenticated user
     *
     * @return object
     */
    public function addRole($role_id) {
      $user = Auth::user();
      $user->roles()->attach($role_id);
      return response()->json(['ok']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function showRole($id)
    {
      $role = Role::findOrFail($id);
      return response()->json(['message' => 'Role encontrado!', 'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request, $id)
    {
      $role = Role::findOrFail($id);
      $role->updateRole($request);
      return response()->json(['message' => 'Role editado!', 'role' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        Role::destroy($id);
        return response()->json(['message' => 'Role deletado!', 'role' => $role]);
    }
}
