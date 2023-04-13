<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Http\FormRequest;

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
            'birth_day'     => 'required|date|before:' . date('Y-m-d', strtotime('-15 years')),
        ];

        if(request('user')){
            $rules['email'] = [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore(request('user'))];
        }else {
            $rules['email'] = [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore(JWTAuth::user())];
        }

        
        return $rules;
    }
}
