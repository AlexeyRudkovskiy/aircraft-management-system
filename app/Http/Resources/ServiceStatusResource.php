<?php

namespace App\Http\Resources;

use App\Enums\ServiceRequest\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceStatusResource extends JsonResource
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
            'status' => $this->status,
            'label' => $this->status->label(),
            'user' => $this->user,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString()
        ];
    }
}
