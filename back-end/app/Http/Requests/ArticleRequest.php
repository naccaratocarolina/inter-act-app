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
            return[
                'title' => 'required|string',
                'description' => 'required|string',
            ];

        }

        protected function failedValidation(Validator $validator) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        public function messages(){
            return[
                'title.aplha' => 'Somente caracteres afabéticos ',
            ];
        }
}
