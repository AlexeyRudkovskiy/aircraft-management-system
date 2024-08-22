<?php

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface UserServiceContract
{

    /**
     * @return Collection<User>
     */
    public function findAll(): Collection;

    /**
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function find(int $id): User;

    /**
     * @param Request $request
     * @return User
     */
    public function store(Request $request): User;

    /**
     * @param User $user
     * @param Request $request
     * @return User
     */
    public function update(User $user, Request $request): User;

    /**
     * @param User $user
     * @return void
     */
    public function delete(User $user): void;

}
