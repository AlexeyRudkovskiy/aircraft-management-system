<?php

namespace App\Http\Controllers\API;

use App\Contracts\AircraftServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAircraftRequest;
use App\Http\Requests\UpdateAircraftRequest;
use App\Http\Resources\AircraftResource;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AircraftController extends Controller
{
    public function __construct(private readonly AircraftServiceContract $aircraftService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = $this->aircraftService->findAll();

        return AircraftResource::collection($items);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAircraftRequest $request)
    {
        $aircraft = $this->aircraftService->store($request);
        return AircraftResource::make($aircraft);
    }

    /**
     * Display the specified resource.
     */
    public function show(Aircraft $aircraft)
    {
        return AircraftResource::make($aircraft);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAircraftRequest $request, Aircraft $aircraft)
    {
        $aircraft = $this->aircraftService->update($aircraft, $request);
        return AircraftResource::make($aircraft);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aircraft $aircraft)
    {
        $this->aircraftService->delete($aircraft);

        return response()->json([])->status(Response::HTTP_OK);
    }
}
