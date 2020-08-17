<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
    //check if information is valid
     public function rules()
        {
            return[
                'title' => 'required|string',
                'category' => 'required|string',
                'description' => 'required|string',
                'image' =>'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
                
                
            ];

        }

        //proct aginst some erro
        protected function failedValidation(Validator $validator) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        //return if information isnt valid
        public function messages(){
            return[
                'title.aplha' => 'Somente caracteres afabéticos ',
                'image.image' => 'Foto inválida ',
            ];
        }
}