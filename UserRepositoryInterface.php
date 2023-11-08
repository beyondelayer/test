<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function getAll();
    public function findOrFail($id);
    public function store(array $data);
    public function updateOrFail($id, array $data);
    public function delete($id);
}
