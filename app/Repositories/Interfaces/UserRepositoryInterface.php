<?php
namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function findByEmail($email);
    public function create(array $data);
    public function getUsersByRole($role);
    public function update($id, array $data);
    public function updateStatus($id, $status);
}
