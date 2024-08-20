<?php

namespace App\Contracts;

use App\Enums\ServiceRequest\Status;
use App\Models\MaintenanceCompany;
use App\Models\ServiceRequest;
use App\Models\ServiceStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface ServiceRequestServiceContract
{

    /**
     * @return Collection<ServiceRequest>
     */
    public function findAll(): Collection;

    /**
     * @param int $id
     * @return ServiceRequest
     * @throws ModelNotFoundException
     */
    public function find(int $id): ServiceRequest;

    /**
     * @param Request $request
     * @return ServiceRequest
     */
    public function store(Request $request): ServiceRequest;

    /**
     * @param ServiceRequest $serviceRequest
     * @param Request $request
     * @return ServiceRequest
     */
    public function update(ServiceRequest $serviceRequest, Request $request): ServiceRequest;

    /**
     * @param ServiceRequest $serviceRequest
     * @param Status $status
     * @return ServiceStatus
     */
    public function updateStatus(ServiceRequest $serviceRequest, Status $status): ServiceStatus;

    /**
     * @param ServiceRequest $serviceRequest
     * @param MaintenanceCompany $company
     * @return ServiceRequest
     */
    public function assignMaintenanceCompany(ServiceRequest $serviceRequest, MaintenanceCompany $company): ServiceRequest;

    /**
     * @param ServiceRequest $company
     * @return void
     */
    public function delete(ServiceRequest $serviceRequest): void;

}
