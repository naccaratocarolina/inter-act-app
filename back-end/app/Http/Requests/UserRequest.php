<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\User;

class UserRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
      return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    if($this->isMethod('post')) {
      return [
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|max:36|min:6',
        'profile_picture'=>'file|image|mimes:jpeg,png,gif,webp|max:2048',
      ];
    }

    if($this->isMethod('put')) {
      return [
        'name' => 'string',
        'email' => 'email|unique:users',
        'password' => 'string|max:36|min:6',
        'description' => 'string|max:84|min:5',
        'profile_picture'=>'file|image|mimes:jpeg,png,gif,webp|max:2048',
      ];
    }
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
   //custom error messages
    public function messages() {
        return [
          'email.email' =>'Insira um email válido',
          'email.unique' =>'Este email já existe'
        ];
    }

    protected function failedValidation(Validator $validator) {
      throw new HttpResponseException(response()->json($validator->errors(),
      422));
    }
}
