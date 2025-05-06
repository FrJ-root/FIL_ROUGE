<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Models\Tag;

class TagRepository implements TagRepositoryInterface
{
    public function getAll()
    {
        return Tag::all();
    }

    public function findById($id)
    {
        return Tag::findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return Tag::where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update($id, array $data)
    {
        $tag = Tag::findOrFail($id);
        $tag->update($data);
        return $tag;
    }

    public function delete($id)
    {
        return Tag::destroy($id);
    }
}
