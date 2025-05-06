<?php
namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function getAll();
    public function delete($id);
    public function findById($id);
    public function findBySlug($slug);
    public function create(array $data);
    public function getFeaturedCategories();
    public function update($id, array $data);
}
