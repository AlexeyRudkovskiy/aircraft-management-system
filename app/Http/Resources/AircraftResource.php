<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AircraftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'serial_number' => $this->serial_number,
            'registration' => $this->registration,
            'maintenance_company_id' => $this->maintenance_company_id,
            'maintenance_company' => MaintenanceCompanyResource::make($this->maintenanceCompany),
            'service_requests' => ServiceRequestResource::collection($this->serviceRequests)
        ];
    }
}
