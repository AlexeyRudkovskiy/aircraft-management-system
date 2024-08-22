<?php

namespace Tests\Unit;

use App\Contracts\AircraftServiceContract;
use App\Contracts\UserServiceContract;
use App\Models\Aircraft;
use App\Models\MaintenanceCompany;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected readonly UserServiceContract $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = app(UserServiceContract::class);

        User::factory()->count(5)->create();
    }

    public function test_it_should_return_all_users()
    {
        // 1. Get all records
        $items = $this->service->findAll();

        // 2. Assert count
        $this->assertEquals(5, $items->count());
        $this->assertDatabaseCount(User::class, $items->count());
    }

    public function test_it_should_find_correct_item()
    {
        // 1. Get real item
        $correct = User::query()->first();

        // 2. Find item by ID
        $item = $this->service->find($correct->id);

        // 3. Assert is equal
        $this->assertEquals($correct->email, $item->email);
        $this->assertEquals($correct->name, $item->name);
        $this->assertEquals($correct->id, $item->id);
    }

    public function test_it_should_throw_an_exception()
    {
        // 1. Expect exception
        $this->expectException(ModelNotFoundException::class);

        // 2. Try to found non-exist record
        $this->service->find(-1);
    }

    public function test_it_should_create_record()
    {
        // 1. Prepare data
        $data = [
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'password'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Try to create a record
        $this->service->store($request);

        // 4. Assert database
        unset($data['password']);
        $this->assertDatabaseHas(User::class, $data);
    }

    public function test_it_should_update_existing_record()
    {
        // 1. Prepare data
        $data = [
            'name' => 'Manager',
            'email' => 'manager@example.com'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Find existing record
        $user = User::query()->first();

        // 4. Try to update the record
        $this->service->update($user, $request);

        // 5. Assert database
        unset($data['password']);
        $this->assertDatabaseHas(User::class, $data);
    }

    public function test_it_should_not_update_password_if_it_not_provided()
    {
        // 1. Prepare data
        $data = [
            'name' => 'Manager',
            'email' => 'manager@example.com'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Find existing record
        $user = User::query()->first();

        // 4. Try to update the record
        $updatedUser = $this->service->update($user, $request);

        // 5. Assert database
        $this->assertEquals($user->password, $updatedUser->password);
    }

    public function test_it_should_update_password()
    {
        // 1. Prepare data
        $data = [
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => 'new_password'
        ];

        // 2. Fill request
        $request = new Request($data);

        // 3. Find existing record
        $user = User::query()->first();
        $old_password = $user->password;

        // 4. Try to update the record
        $updatedUser = $this->service->update($user, $request);

        // 5. Assert database
        $this->assertNotEquals($old_password, $updatedUser->password);
        $this->assertTrue(Hash::check('new_password', $updatedUser->password));
    }

    public function test_it_should_delete_record()
    {
        // 1. Get real item
        $correct = User::query()->first();

        // 2. Delete the item
        $this->service->delete($correct);

        // 3. Assert is equal
        $this->assertDatabaseMissing(User::class, [
            'id' => $correct->id
        ]);
    }

}
