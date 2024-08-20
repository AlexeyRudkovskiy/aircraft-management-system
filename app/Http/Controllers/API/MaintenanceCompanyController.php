<?php

namespace App\Http\Controllers\API;

use App\Contracts\MaintenanceCompanyServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMaintenanceCompanyRequest;
use App\Http\Requests\UpdateMaintenanceCompanyRequest;
use App\Http\Resources\MaintenanceCompanyResource;
use App\Models\MaintenanceCompany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MaintenanceCompanyController extends Controller
{
    public function __construct(private readonly MaintenanceCompanyServiceContract $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->service->findAll();
        return MaintenanceCompanyResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceCompanyRequest $request)
    {
        $maintenanceCompany = $this->service->store($request);
        return MaintenanceCompanyResource::make($maintenanceCompany);
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceCompany $maintenanceCompany)
    {
        return MaintenanceCompanyResource::make($maintenanceCompany);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceCompanyRequest $request, MaintenanceCompany $maintenanceCompany)
    {
        $maintenanceCompany = $this->service->update($maintenanceCompany, $request);
        return MaintenanceCompanyResource::make($maintenanceCompany);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceCompany $maintenanceCompany)
    {
        $this->service->delete($maintenanceCompany);
        return response()->json()->setStatusCode(Response::HTTP_OK);
    }
}
