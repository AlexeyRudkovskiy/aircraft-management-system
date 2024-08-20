<?php

namespace App\Services;

use App\Contracts\AircraftServiceContract;
use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AircraftService implements AircraftServiceContract
{

    public function findAll(): Collection
    {
        return Aircraft::query()->latest()->get();
    }

    public function find(int $id): Aircraft
    {
        return Aircraft::query()->findOrFail($id);
    }

    public function store(Request $request): Aircraft
    {
        $aircraft = new Aircraft();
        $aircraft->fill($request->only([
            'model', 'serial_number', 'registration'
        ]));
        $aircraft->save();

        return $aircraft;
    }

    public function update(Aircraft $aircraft, Request $request): Aircraft
    {
        $aircraft->fill($request->only([
            'model', 'serial_number', 'registration'
        ]));
        $aircraft->save();

        return $aircraft;
    }

    public function assignMaintenanceCompany(Aircraft $aircraft, MaintenanceCompany $maintenanceCompany): Aircraft
    {
        $maintenanceCompany->aircrafts()->save($aircraft);
        return $aircraft->fresh();
    }

    public function delete(Aircraft $aircraft): void
    {
        $aircraft->delete();
    }
}
