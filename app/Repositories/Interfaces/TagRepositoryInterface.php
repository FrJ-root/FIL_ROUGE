<?php
namespace App\Repositories\Interfaces;

interface TagRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function findBySlug($slug);
    public function create(array $data);
    public function update($id, array $data);
}
