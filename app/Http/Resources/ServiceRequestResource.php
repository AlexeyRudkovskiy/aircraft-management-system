<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceRequestResource extends JsonResource
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
            'description' => $this->description,
            'priority' => $this->priority,
            'maintenance_company_id' => $this->maintenance_company_id,
            'maintenance_company' => $this->maintenanceCompany,
            'status' => $this->currentStatus,
            'statuses' => ServiceStatusResource::collection($this->serviceStatuses)
        ];
    }
}
