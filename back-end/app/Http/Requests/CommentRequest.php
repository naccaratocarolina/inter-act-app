<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Comment;


class CommentRequest extends FormRequest
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
                
                'commentary' => 'required|string',
            ];
        }
        if($this->isMethod('put')){
            return[
                
                'commentary' => 'required|string',
            ];
        }
        if($this->isMethod('get')){
            return[
                
                'commentary' => 'required|string',
            ];
        }
        if($this->isMethod('delete')){
            return[
                
                'commentary' => 'required|string',
            ];
        }
            
        
    }
}
