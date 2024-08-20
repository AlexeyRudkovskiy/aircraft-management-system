<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAircraftRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model' => 'required',
            'serial_number' => [ 'required', 'numeric', Rule::unique('aircraft', 'serial_number') ],
            'registration' => 'required',
            'maintenance_company_id' => [ 'required', Rule::exists('maintenance_companies', 'id') ]
        ];
    }
}
