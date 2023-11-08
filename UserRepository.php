<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    protected function __construct
    (protected User $user)
    {}

    public function getAll()
    {
        return $this->user->all();
    }

    public function findOrFail($id)
    {

    }

    public function store(array $data, array $detail)
    {
        $user = new $this->user($data);
        $user->save();

        if (!$user->id) {
            return null;
        }

        $userDetail = new $this->detail($detail);
        $user->details()->save($userDetail);

        if (!$userDetail->id) {
            return null;
        }

        return $user;
    }

    public function updateOrFail($id, array $data)
    {

    }

    public function delete($id)
    {

    }
}
