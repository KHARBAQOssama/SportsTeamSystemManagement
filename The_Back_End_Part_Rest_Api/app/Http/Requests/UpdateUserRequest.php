<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'birth_day'     => 'required|date',
            'password'      => 'required|string|min:8',
            'image_url'     => 'nullable|url',
        ];

        if(request('email') != JWTAuth::user()->email){
            $rules['email'] = 'required|email|unique:users,email';
        }else{
            $rules['email'] = 'required|email';
        }
        
        return $rules;
    }
}
