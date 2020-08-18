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
          if($this->isMethod('post')) {
            return[
                'title' => 'required|string|max:57|min:5',
                'subtitle' => 'required|string|max:83|min:12',
                'text' => 'required|string',
                'category' => 'required|string',
                'image' =>'file|image|mimes:jpeg,png,gif,webp|max:2048'
            ];
          }
          if($this->isMethod('put')) {
            return[
              'title' => 'string|max:57|min:5',
              'subtitle' => 'string|max:83|min:12',
              'text' => 'string',
              'category' => 'string',
              'image' =>'file|image|mimes:jpeg,png,gif,webp|max:2048'
            ];
          }
        }

        public function messages(){
            return[
                'title.aplha' => 'Somente caracteres afabéticos ',
                'image.file' => 'Somente fotos no padrão jpeg,png,gif,webp|max:2048 ',
            ];
        }

        protected function failedValidation(Validator $validator) {
           throw new HttpResponseException(response()->json($validator->errors(), 422));
        }
}
