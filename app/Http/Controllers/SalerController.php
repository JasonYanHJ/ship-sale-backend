<?php

namespace App\Http\Controllers;

use App\Models\Saler;
use Illuminate\Http\Request;

class SalerController extends Controller
{
    /**
     * Display a listing of the salers.
     */
    public function index()
    {
        $salers = Saler::with('tags')->get();

        return response()->json([
            'data' => $salers,
        ]);
    }

    /**
     * Store a newly created saler in database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:salers',
            'description' => 'nullable|string',
            'tag_names' => 'nullable|array',
            'tag_names.*' => 'string|max:255',
        ]);

        $saler = Saler::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'description' => $validated['description'] ?? null,
        ]);

        // 处理标签
        if (isset($validated['tag_names']) && !empty($validated['tag_names'])) {
            $saler->syncTags($validated['tag_names']);
        }

        return response()->json([
            'message' => '创建成功',
            'data' => $saler,
        ], 201);
    }

    /**
     * Display the specified saler.
     */
    public function show(Saler $saler)
    {
        return response()->json([
            'data' => $saler->load('tags'),
        ]);
    }

    /**
     * Update the specified saler in database.
     */
    public function update(Request $request, Saler $saler)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:salers,email,' . $saler->id,
            'description' => 'sometimes|nullable|string',
            'tag_names' => 'sometimes|nullable|array',
            'tag_names.*' => 'string|max:255',
        ]);

        // 只更新请求中提供的字段
        $saler->update($request->only(['name', 'email', 'description']));

        // 处理标签
        if (isset($validated['tag_names'])) {
            $saler->syncTags($validated['tag_names']);
        }

        return response()->json([
            'message' => '更新成功',
            'data' => $saler->load('tags'),
        ]);
    }

    /**
     * Remove the specified saler from database.
     */
    public function destroy(Saler $saler)
    {
        $saler->delete();

        return response()->json([
            'message' => '删除成功',
        ]);
    }
}
