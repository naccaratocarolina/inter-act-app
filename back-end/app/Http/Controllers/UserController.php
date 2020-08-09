<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\UserRequest as UserRequest;

use App\User;
use App\Role;

class UserController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
    public function construct()
    {
      $this->middleware('role');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexUser()
    {
        $users = User::orderBy('id', 'desc')->get();
        return response()->json(['users' => $users]);
    }

    /**
     * Create a new User
     * And assign a Role & Permission
     * @return \Illuminate\Http\Response
     */
     public function createUser(UserRequest $request)
     {
       $user = new User;
       $user->createUser($request);
       return response()->json(['message' => 'User criado!', 'user' => $user]);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUser($id)
    {
      $user = User::findOrFail($id);
      return response()->json(['message' => 'User encontrado!', 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function updateUser(Request $request, $id)
     {
       $user = User::find($id);
       $user->updateUser($request);
       return response()->json(['message' => 'User editado!', 'user' => $user]);
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroyUser($id)
     {
       $user = User::findOrFail($id);
       if($user->roles() != null) {
         $user->roles()->detach();
       }
       User::destroy($id);
       return response()->json(['message' => 'User deletado!', 'user' => $user]);
      }

      /**
       * Check if the user has a role assigned
       * @return bool
       */
      public function hasRole($roles)
      {
        //receives an array of roles and checks if the user is associated
        foreach($roles as $role) {
          if($this->roles->contains('marker', $role)) {
            return true; //if yes, returns true
          }
        }
        return false; //if no, returns false
      }

      /**
       * Check if the user is a moderator
       * @return bool
       */
      public function isModerator()
      {
        if($this->roles->contains('marker', 'moderator')) {
          return true;
        }
      }

      /**
       * Check if the user is a registered
       * @return bool
       */
      public function isRegisteredUser()
      {
        if($this->roles->contains('marker', 'registered-user')) {
          return true;
        }
      }
}
