<?php

namespace App\Services;

use App\Contracts\ServiceRequestServiceContract;
use App\Enums\ServiceRequest\Status;
use App\Models\MaintenanceCompany;
use App\Models\ServiceRequest;
use App\Models\ServiceStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ServiceRequestService implements ServiceRequestServiceContract
{

    public function findAll(): Collection
    {
        return ServiceRequest::query()->latest()->get();
    }

    public function find(int $id): ServiceRequest
    {
        return ServiceRequest::query()->findOrFail($id);
    }

    public function store(Request $request): ServiceRequest
    {
        $serviceRequest = new ServiceRequest();
        $serviceRequest->fill($request->only([
            'description', 'priority', 'due_date', 'aircraft_id', 'maintenance_company_id'
        ]));
        $serviceRequest->save();
        $this->updateStatus($serviceRequest, Status::PENDING);

        return $serviceRequest;
    }

    public function update(ServiceRequest $serviceRequest, Request $request): ServiceRequest
    {
        $serviceRequest->fill($request->only([
            'description', 'priority', 'due_date'
        ]));
        $serviceRequest->save();

        return $serviceRequest;
    }

    /**
     * @param ServiceRequest $serviceRequest
     * @param ServiceStatus $status
     * @return ServiceStatus
     */
    public function updateStatus(ServiceRequest $serviceRequest, Status $status): ServiceStatus
    {
        $serviceStatus = new ServiceStatus();
        $serviceStatus->status = $status;
        $serviceStatus->user_id = auth()->id();
        $serviceRequest->serviceStatuses()->save($serviceStatus);

        return $serviceStatus;
    }

    /**
     * @param ServiceRequest $serviceRequest
     * @param MaintenanceCompany $company
     * @return ServiceRequest
     */
    public function assignMaintenanceCompany(ServiceRequest $serviceRequest, MaintenanceCompany $company): ServiceRequest
    {
        $company->serviceRequests()->save($serviceRequest);
        return $serviceRequest->fresh();
    }

    public function delete(ServiceRequest $serviceRequest): void
    {
        $serviceRequest->delete();
    }
}
