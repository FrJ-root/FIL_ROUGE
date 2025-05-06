<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll()
    {
        return Category::all();
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return Category::where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update($id, array $data)
    {
        $category = Category::findOrFail($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        return Category::destroy($id);
    }

    public function getFeaturedCategories()
    {
        return Category::where('is_featured', true)->get();
    }
}
