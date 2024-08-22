<?php

namespace Tests\Unit;

use App\Contracts\AircraftServiceContract;
use App\Contracts\ServiceRequestServiceContract;
use App\Enums\ServiceRequest\Priority;
use App\Enums\ServiceRequest\Status;
use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use App\Models\ServiceRequest;
use App\Models\ServiceStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class ServiceRequestServiceTest extends TestCase
{
    use RefreshDatabase;

    protected readonly ServiceRequestServiceContract $serviceContract;

    public function setUp(): void
    {
        parent::setUp();
        $this->serviceContract = app(ServiceRequestServiceContract::class);

        ServiceRequest::factory()->count(5)->create();
    }

    public function test_it_should_return_all_requests()
    {
        // 1. Get all records
        $items = $this->serviceContract->findAll();

        // 2. Assert count
        $this->assertEquals(5, $items->count());
        $this->assertDatabaseCount(ServiceRequest::class, $items->count());
    }

    public function test_it_should_find_correct_item()
    {
        // 1. Get real item
        $correct = ServiceRequest::query()->first();

        // 2. Find item by ID
        $item = $this->serviceContract->find($correct->id);

        // 3. Assert is equal
        $this->assertEquals($correct->description, $item->description);
        $this->assertEquals($correct->priority, $item->priority);
        $this->assertEquals($correct->due_date, $item->due_date);
    }

    public function test_it_should_throw_an_exception()
    {
        // 1. Expect exception
        $this->expectException(ModelNotFoundException::class);

        // 2. Try to found non-exist record
        $this->serviceContract->find(-1);
    }

    public function test_it_should_create_record()
    {
        // 1. Create user and authenticate it
        $user = User::factory()->create();
        auth()->login($user);

        // 2. Create new aircraft
        $aircraft = Aircraft::factory()->create();

        // 3. Create new maintenance company
        $maintenanceCompany = MaintenanceCompany::factory()->create();

        // 4. Prepare data
        $data = [
            'description' => 'Test',
            'priority' => Priority::LOW,
            'due_date' => today()->addDays(5),
            'aircraft_id' => $aircraft->id,
            'maintenance_company_id' => $maintenanceCompany->id
        ];

        // 5. Fill request
        $request = new Request($data);

        // 6. Try to create a record
        $this->serviceContract->store($request);

        // 7. Assert database
        $this->assertDatabaseHas(ServiceRequest::class, $data);
    }

    public function test_it_should_update_existing_record()
    {
        // 1. Prepare data
        $data = [
            'description' => 'Test',
            'priority' => Priority::HIGH,
            'due_date' => today()->addDays(5),
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Find existing record
        $serviceRequest = ServiceRequest::query()->first();

        // 4. Try to update the record
        $this->serviceContract->update($serviceRequest, $request);

        // 5. Assert database
        $this->assertDatabaseHas(ServiceRequest::class, $data);
    }

    public function test_it_should_delete_record()
    {
        // 1. Get real item
        $correct = ServiceRequest::query()->first();

        // 2. Delete the item
        $this->serviceContract->delete($correct);

        // 3. Assert is equal
        $this->assertDatabaseMissing(ServiceRequest::class, [
            'id' => $correct->id
        ]);
    }

    public function test_it_should_change_maintenance_company()
    {
        // 1. Create new record
        $serviceRequest = ServiceRequest::factory()->create();

        // 2. Create maintenance company
        $maintenanceCompany = MaintenanceCompany::factory()->create();

        // 3. Assign maintenance company
        $serviceRequest->maintenance_company_id = $maintenanceCompany->id;

        // 4. Try to update maintenance company
        $newMaintenanceCompany = MaintenanceCompany::factory()->create();
        $this->serviceContract->assignMaintenanceCompany($serviceRequest, $newMaintenanceCompany);

        // 5. Assert database changes
        $this->assertDatabaseHas(ServiceRequest::class, [
            'id' => $serviceRequest->id,
            'maintenance_company_id' => $newMaintenanceCompany->id
        ]);
    }

    public function test_it_should_save_new_status()
    {
        // 1. Get existing service request
        $serviceRequest = ServiceRequest::query()->first();

        // 2. Create new user
        $user = User::factory()->create();

        // 3. Login as newly created user
        auth()->loginUsingId($user->id);

        // 4. Try to add new status
        $this->serviceContract->updateStatus($serviceRequest, Status::PENDING);

        // 5. Assert database
        $this->assertDatabaseHas(ServiceStatus::class, [
            'service_request_id' => $serviceRequest->id,
            'status' => Status::PENDING
        ]);
    }

    public function test_it_should_store_correct_statuses()
    {
        // 1. Get existing service request
        /** @var ServiceRequest $serviceRequest */
        $serviceRequest = ServiceRequest::query()->first();

        // 2. Create new user
        $user = User::factory()->create();

        // 3. Sign in as newly created user
        auth()->loginUsingId($user->id);

        // 4. Add first status
        $this->serviceContract->updateStatus($serviceRequest, Status::PENDING);
        sleep(1);

        // 5. Add second status
        $this->serviceContract->updateStatus($serviceRequest, Status::IN_PROGRESS);

        // 6. Get statuses
        $statuses = $serviceRequest->serviceStatuses;

        // 7. Assert statuses
        $this->assertCount(2, $statuses);
        $this->assertEquals(Status::IN_PROGRESS, $statuses->get(0)->status);
        $this->assertEquals(Status::PENDING, $statuses->get(1)->status);
    }

}
