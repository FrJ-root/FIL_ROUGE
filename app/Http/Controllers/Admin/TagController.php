<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    protected $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function index()
    {
        $tags = $this->tagRepository->getAll();
        return view('admin.pages.tags', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:tags,name'
        ]);

        $tag = $this->tagRepository->create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'message' => 'Tag created successfully',
            'tag' => $tag
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $tag = $this->tagRepository->findById($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags')->ignore($tag->id)
            ]
        ]);

        $tag = $this->tagRepository->update($id, [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'message' => 'Tag updated successfully',
            'tag' => $tag
        ]);
    }

    public function destroy($id)
    {
        $this->tagRepository->delete($id);

        return response()->json([
            'message' => 'Tag deleted successfully'
        ]);
    }
}
