<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listRoles()
    {
        $roles = Role::orderBy('id', 'desc')->get();
        return response()->json(['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRole(Request $request)
    {
      $role = new Role();

      $role->name = $request->name;
      $role->marker = $role->marker;
      $role->save();

      //cria um array de permissoes separado por virgula
      $permissions = explode(',', $request->roles_permissions);

      foreach($permission as $permission) {
        $permissions = new Permission();
        $permissions->name = $permission;
        $permissions->marker = strtolower(str_replace(" ", "-", $permission));
        $permissions->save();
        $role->permissions()->attach($permissions->id);
        $role->save();
      }

      return response()->json(['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        //validating request
        if($role) {
          if($request->name) {
            $role->name = $request->name;
          }
          if($request->marker) {
            $role->marker = $request->marker;
          }
          $role->save();
          return response()->json(['message' => 'Role editado!', 'role' => $role]);
        }
        else {
          return response()->json(['message' => 'Vc nao tem permissao ou o role nao existe!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $role = Role:findOrFail($id);
      Role::destroy($id);
      return response()->json(['message' => 'Role deletado!', 'role' => $role]);
    }
}
