<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_name' => ['required' , 'string' ] ,
            'email' => ['required' , 'email' , 'unique:users,email,'.request()->route('user')] ,
            'password' => ['nullable' , 'string' ,'min:8'] ,
        ];
    }
}
