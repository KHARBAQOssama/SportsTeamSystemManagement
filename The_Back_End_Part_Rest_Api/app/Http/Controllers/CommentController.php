<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Comment::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content'=>'required'
        ]);

        $credentials = [
            'content' => $request->input('content'),
            'user_id' => JWTAuth::user()->id,
            'blog_id' => $request->input('blog_id')
        ];

        $comment = Comment::create($credentials);

        return response()->json(['success' => 'comment has been added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content'=>'required'
        ]);

        $credentials = [
            'content' => $request->input('content'),
        ];

        $comment->update($credentials);

        return response()->json(['success' => 'comment has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(['success' => 'comment has been deleted successfully']);
    }
}
