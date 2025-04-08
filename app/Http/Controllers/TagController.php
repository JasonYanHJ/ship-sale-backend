<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the tags.
     */
    public function index()
    {
        $tags = Tag::all();

        return response()->json([
            'data' => $tags
        ]);
    }

    /**
     * Store a newly created tag in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags',
        ]);

        $tag = Tag::create($validated);

        return response()->json([
            'message' => '创建成功',
            'data' => $tag
        ], 201);
    }

    /**
     * Display the specified tag.
     */
    public function show(Tag $tag)
    {
        return response()->json([
            'data' => $tag
        ]);
    }

    /**
     * Update the specified tag in database.
     */
    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $tag->id,
        ]);

        $tag->update($validated);

        return response()->json([
            'message' => '更新成功',
            'data' => $tag
        ]);
    }

    /**
     * Remove the specified tag from database.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([
            'message' => '删除成功'
        ]);
    }
}
