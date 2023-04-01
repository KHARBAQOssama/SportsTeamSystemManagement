<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrUpdateTournamentRequest extends FormRequest
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
        return [
            'name'        => 'required|string',
            'win_points'  => 'required|integer',
            'loss_points' => 'required|integer',
            'draw_points' => 'required|integer',
            'start_date'  => 'required|date|after:today',
            'teams'       => 'required|array',
            'teams,*'     => 'exists:teams,id',
        ];
    }
}