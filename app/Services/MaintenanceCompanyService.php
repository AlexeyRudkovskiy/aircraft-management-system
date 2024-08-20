<?php

namespace App\Services;

use App\Contracts\MaintenanceCompanyServiceContract;
use App\Models\MaintenanceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MaintenanceCompanyService implements MaintenanceCompanyServiceContract
{

    public function findAll(): Collection
    {
        return MaintenanceCompany::query()->latest()->get();
    }

    public function find(int $id): MaintenanceCompany
    {
        return MaintenanceCompany::query()->findOrFail($id);
    }

    public function store(Request $request): MaintenanceCompany
    {
        $company = new MaintenanceCompany();
        $company->fill($request->only([
            'name', 'contact', 'specialization'
        ]));
        $company->save();

        return $company;
    }

    public function update(MaintenanceCompany $company, Request $request): MaintenanceCompany
    {
        $company->fill($request->only([
            'name', 'contact', 'specialization'
        ]));
        $company->save();

        return $company;
    }

    public function delete(MaintenanceCompany $company): void
    {
        $company->delete();
    }
}
