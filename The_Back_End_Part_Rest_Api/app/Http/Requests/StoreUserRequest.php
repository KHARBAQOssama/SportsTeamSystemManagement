<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email'         => 'required|email|unique:users,email',
            'birth_day'     => 'required|date',
            'password'      => 'required|string|min:8|confirmed',
            'image_url'     => 'nullable|url',
        ];
        if(request('role_id') && request('role_id') != 1){
            $rules['sport_id'] = 'required|integer';
        }
        return $rules;
    }
}
