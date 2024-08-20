<?php

namespace App\Contracts;

use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface AircraftServiceContract
{

    /**
     * @return Collection<Aircraft>
     */
    public function findAll(): Collection;

    /**
     * @param int $id
     * @return Aircraft
     * @throws ModelNotFoundException
     */
    public function find(int $id): Aircraft;

    /**
     * @param Request $request
     * @return Aircraft
     */
    public function store(Request $request): Aircraft;

    /**
     * @param Aircraft $aircraft
     * @param Request $request
     * @return Aircraft
     */
    public function update(Aircraft $aircraft, Request $request): Aircraft;

    public function assignMaintenanceCompany(Aircraft $aircraft, MaintenanceCompany $maintenanceCompany): Aircraft;

    /**
     * @param Aircraft $aircraft
     * @return mixed
     */
    public function delete(Aircraft $aircraft): void;

}
