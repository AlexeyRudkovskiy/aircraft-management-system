<?php

namespace App\Contracts;

use App\Models\MaintenanceCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface MaintenanceCompanyServiceContract
{

    /**
     * @return Collection<MaintenanceCompany>
     */
    public function findAll(): Collection;

    /**
     * @param int $id
     * @return MaintenanceCompany
     * @throws ModelNotFoundException
     */
    public function find(int $id): MaintenanceCompany;

    /**
     * @param Request $request
     * @return MaintenanceCompany
     */
    public function store(Request $request): MaintenanceCompany;

    /**
     * @param MaintenanceCompany $company
     * @param Request $request
     * @return MaintenanceCompany
     */
    public function update(MaintenanceCompany $company, Request $request): MaintenanceCompany;

    /**
     * @param MaintenanceCompany $company
     * @return void
     */
    public function delete(MaintenanceCompany $company): void;

}
