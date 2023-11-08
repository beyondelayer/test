<?php

namespace App\Services\User;

use App\Repositories\User\UserRepository;

class UserService
{
    public function __construct
    (protected UserRepository $repository)
    {}

    protected function getRepository(): UserRepository
    {
        return $this->repository;
    }

    public function getAll()
    {
        return $this->getRepository()
            ->getAll();
    }

}
