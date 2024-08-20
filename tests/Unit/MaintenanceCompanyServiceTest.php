<?php

namespace Tests\Unit;

use App\Contracts\AircraftServiceContract;
use App\Contracts\MaintenanceCompanyServiceContract;
use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class MaintenanceCompanyServiceTest extends TestCase
{
    use RefreshDatabase;

    protected readonly MaintenanceCompanyServiceContract $maintenanceCompanyService;

    public function setUp(): void
    {
        parent::setUp();
        $this->maintenanceCompanyService = app(MaintenanceCompanyServiceContract::class);

        MaintenanceCompany::factory()->count(5)->create();
    }

    public function test_it_should_return_all_companies()
    {
        // 1. Get all records
        $items = $this->maintenanceCompanyService->findAll();

        // 2. Assert count
        $this->assertEquals(5, $items->count());
        $this->assertDatabaseCount(MaintenanceCompany::class, $items->count());
    }

    public function test_it_should_find_correct_item()
    {
        // 1. Get real item
        $correct = MaintenanceCompany::query()->first();

        // 2. Find item by ID
        $item = $this->maintenanceCompanyService->find($correct->id);

        // 3. Assert is equal
        $this->assertEquals($correct->name, $item->name);
        $this->assertEquals($correct->contact, $item->contact);
    }

    public function test_it_should_throw_an_exception()
    {
        // 1. Expect exception
        $this->expectException(ModelNotFoundException::class);

        // 2. Try to found non-exist record
        $this->maintenanceCompanyService->find(-1);
    }

    public function test_it_should_create_record()
    {
        // 1. Prepare data
        $data = [
            'name' => 'Test',
            'contact' => '+380660000000',
            'specialization' => 'Test'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Try to create a record
        $this->maintenanceCompanyService->store($request);

        // 4. Assert database
        $this->assertDatabaseHas(MaintenanceCompany::class, $data);
    }

    public function test_it_should_update_existing_record()
    {
        // 1. Prepare data
        $data = [
            'name' => 'Test',
            'contact' => '+380660000000',
            'specialization' => 'Test'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Find existing record
        $company = MaintenanceCompany::query()->first();

        // 4. Try to update the record
        $this->maintenanceCompanyService->update($company, $request);

        // 5. Assert database
        $this->assertDatabaseHas(MaintenanceCompany::class, $data);
    }

    public function test_it_should_delete_record()
    {
        // 1. Get real item
        $correct = MaintenanceCompany::query()->first();

        // 2. Delete the item
        $this->maintenanceCompanyService->delete($correct);

        // 3. Assert is equal
        $this->assertDatabaseMissing(MaintenanceCompany::class, [
            'id' => $correct->id
        ]);
    }

}
