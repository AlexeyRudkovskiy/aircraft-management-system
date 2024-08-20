<?php

namespace Tests\Unit;

use App\Contracts\AircraftServiceContract;
use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class AircraftServiceTest extends TestCase
{
    use RefreshDatabase;

    protected readonly AircraftServiceContract $aircraftService;

    public function setUp(): void
    {
        parent::setUp();
        $this->aircraftService = app(AircraftServiceContract::class);

        Aircraft::factory()->count(5)->create();
    }

    public function test_it_should_return_all_aircrafts()
    {
        // 1. Get all records
        $items = $this->aircraftService->findAll();

        // 2. Assert count
        $this->assertEquals(5, $items->count());
        $this->assertDatabaseCount(Aircraft::class, $items->count());
    }

    public function test_it_should_find_correct_item()
    {
        // 1. Get real item
        $correct = Aircraft::query()->first();

        // 2. Find item by ID
        $item = $this->aircraftService->find($correct->id);

        // 3. Assert is equal
        $this->assertEquals($correct->model, $item->model);
        $this->assertEquals($correct->serial_number, $item->serial_number);
    }

    public function test_it_should_throw_an_exception()
    {
        // 1. Expect exception
        $this->expectException(ModelNotFoundException::class);

        // 2. Try to found non-exist record
        $this->aircraftService->find(-1);
    }

    public function test_it_should_create_record()
    {
        // 1. Prepare data
        $data = [
            'model' => 'Test',
            'serial_number' => 100,
            'registration' => 'A1111'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Try to create a record
        $this->aircraftService->store($request);

        // 4. Assert database
        $this->assertDatabaseHas(Aircraft::class, $data);
    }

    public function test_it_should_update_existing_record()
    {
        // 1. Prepare data
        $data = [
            'model' => 'Test',
            'serial_number' => 100,
            'registration' => 'A1111'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Find existing record
        $aircraft = Aircraft::query()->first();

        // 4. Try to update the record
        $this->aircraftService->update($aircraft, $request);

        // 5. Assert database
        $this->assertDatabaseHas(Aircraft::class, $data);
    }

    public function test_it_should_delete_record()
    {
        // 1. Get real item
        $correct = Aircraft::query()->first();

        // 2. Delete the item
        $this->aircraftService->delete($correct);

        // 3. Assert is equal
        $this->assertDatabaseMissing(Aircraft::class, [
            'id' => $correct->id
        ]);
    }

    public function test_it_should_change_maintenance_company()
    {
        // 1. Create new record
        $aircraft = Aircraft::factory()->create();

        // 2. Create maintenance company
        $maintenanceCompany = MaintenanceCompany::factory()->create();

        // 3. Assign maintenance company
        $aircraft->maintenance_company_id = $maintenanceCompany->id;

        // 4. Try to update maintenance company
        $newMaintenanceCompany = MaintenanceCompany::factory()->create();
        $this->aircraftService->assignMaintenanceCompany($aircraft, $newMaintenanceCompany);

        // 5. Assert database changes
        $this->assertDatabaseHas(Aircraft::class, [
            'id' => $aircraft->id,
            'maintenance_company_id' => $newMaintenanceCompany->id
        ]);
    }

}
