<?php

namespace App\Http\Requests;

use App\Models\Role;
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
            'birth_day'     => 'required|date|before:' . date('Y-m-d', strtotime('-15 years')),
            'password'      => 'required|string|min:8|confirmed',
            'image_url'     => 'nullable|url',
            'sport_id'      => 'required|integer'
        ];
        $admin = Role::where('name','admin')->first()->id;
        $fan = Role::where('name','fan')->first()->id;
        if(request('role_id')){
            if(request('role_id') == $admin || request('role_id') == $fan){
                $rules['sport_id'] = '';
            }
        }
        return $rules;
    }
}
