<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAircraftRequest extends FormRequest
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
        $id = $this->aircraft->id;

        return [
            'model' => 'sometimes',
            'serial_number' => [ 'sometimes', 'numeric', Rule::unique('aircraft', 'serial_number')->ignore($id) ],
            'registration' => 'sometimes',
            'maintenance_company_id' => [ 'sometimes', Rule::exists('maintenance_companies', 'id') ]
        ];
    }
}
