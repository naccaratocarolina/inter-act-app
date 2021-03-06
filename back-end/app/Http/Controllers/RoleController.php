<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest as RoleRequest;

use App\User;
use Auth;

class RoleController extends Controller
{
    public function construct()
    {
      $this->middleware('moderator');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexRole()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return response()->json(['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
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
     * @param $role_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addRole($role_id)
    {
      $user = Auth::user();
      $user->roles()->attach($role_id);
      return response()->json(['ok']);
    }

    /**
     * Add a moderator marker to an authenticated user
     *
     * @param $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignModerator($user_id)
    {
      $user = User::findOrFail($user_id);
      $moderator = Role::where('marker', 'moderator')->first();
      $user->roles()->attach($moderator);
      $user->save();
      return response()->json(['message' => $user->name . ' agora eh moderador!']);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showRole($id)
    {
      $role = Role::findOrFail($id);
      return response()->json(['message' => 'Role encontrado!', 'role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateRole(RoleRequest $request, $id)
    {
      $role = Role::findOrFail($id);
      $role->updateRole($request);
      return response()->json(['message' => 'Role editado!', 'role' => $role]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyRole($id)
    {
        $role = Role::findOrFail($id);
        Role::destroy($id);
        return response()->json(['message' => 'Role deletado!', 'role' => $role]);
    }
}
