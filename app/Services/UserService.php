<?php

namespace App\Services;

use App\Contracts\UserServiceContract;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceContract
{

    public function findAll(): Collection
    {
        return User::query()->latest()->get();
    }

    public function find(int $id): User
    {
        return User::query()->findOrFail($id);
    }

    public function store(Request $request): User
    {
        $user = new User();
        $user->fill($request->only([
            'name', 'email'
        ]));
        $password = $request->get('password');
        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }

    public function update(User $user, Request $request): User
    {
        $user->fill($request->only([
            'name', 'email'
        ]));
        if ($request->has('password') && strlen($request->get('password')) > 0) {
            $password = $request->get('password');
            $user->password = Hash::make($password);
        }

        $user->save();
        return $user->fresh();
    }

    public function delete(User $user): void
    {
        $user->delete();
    }
}
