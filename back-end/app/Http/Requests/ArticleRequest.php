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
     public function rules()
        {
            return[
                'title' => 'required|string',
                'category' => 'required|string',
                'description' => 'required|string',
                'image' =>'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
                
                
            ];

        }

        protected function failedValidation(Validator $validator) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        public function messages(){
            return[
                'title.aplha' => 'Somente caracteres afabéticos ',
                'image.image' => 'Foto inválida ',
            ];
        }
}
