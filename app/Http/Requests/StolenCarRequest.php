<?php

namespace App\Http\Requests;

use App\Rules\VIN;
use Illuminate\Foundation\Http\FormRequest;

class StolenCarRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:191',
            'registration_number' => 'required|string|min:4|max:20',
            'color' => 'required|string|max:50',
            'vin' => ['required', 'string', 'size:17', 'alpha_num', new VIN(), 'unique:stolen_cars'],
        ];
    }
}
