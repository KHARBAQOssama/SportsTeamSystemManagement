<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' =>'required|',
            'short_description' => 'required|max:50',
            'description' => 'required|max:1000|min:300',
            'price' => 'required',
            'quantity' => 'required',
            'images' => 'array|required',
        ];
    }
}
