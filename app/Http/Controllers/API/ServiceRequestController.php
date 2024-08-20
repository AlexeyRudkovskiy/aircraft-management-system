<?php

namespace App\Http\Controllers\API;

use App\Contracts\ServiceRequestServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Http\Resources\ServiceRequestResource;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceRequestController extends Controller
{
    public function __construct(private readonly ServiceRequestServiceContract $service)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->service->findAll();
        return ServiceRequestResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $serviceRequest = $this->service->store($request);
        return ServiceRequestResource::make($serviceRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        return ServiceRequestResource::make($serviceRequest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, ServiceRequest $serviceRequest)
    {
        $serviceRequest = $this->service->update($serviceRequest, $request);
        return ServiceRequestResource::make($serviceRequest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        $this->service->delete($serviceRequest);
        return response()->json()->setStatusCode(Response::HTTP_OK);
    }
}
