<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
             if($this->isMethod('post')){
                 return[
                     'title' => 'required|string',
                     'description' => 'required|string',
                 ];
             }
             if($this->isMethod('put')){
                 return[
                     'title' => 'required|string',
                     'description' => 'required|string',
                 ];
             }
             if($this->isMethod('get')){
                 return[
                     'title' => 'required|string',
                     'description' => 'required|string',
                 ];
             }
             if($this->isMethod('delete')){
                 return[
                     'title' => 'required|string',
                     'description' => 'required|string',
                 ];
             }

         }

         public function messages(){
             return[
                 'title.aplha' => 'Somente caracteres afabéticos ',
             ];
         }
}
