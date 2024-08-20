<?php

namespace App\Http\Requests;

use App\Enums\ServiceRequest\Priority;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
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
        $allowedPriorities = array_column(Priority::cases(), 'value');

        return [
            'description' => 'required',
            'priority' => [ 'required', Rule::in($allowedPriorities) ],
            'due_date' => ['required', 'date'],
            'aircraft_id' => ['required', Rule::exists('aircraft', 'id')],
            'maintenance_company_id' => ['required', Rule::exists('maintenance_companies', 'id')]
        ];
    }
}
