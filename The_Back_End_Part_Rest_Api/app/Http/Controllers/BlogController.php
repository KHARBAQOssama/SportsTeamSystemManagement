<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Blog::all());
    }

    public function getBlogComments(Blog $blog){
        return response()->json($blog->comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $credentials = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => JWTAuth::user()->id,
        ];

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $blog = Blog::create($credentials);

        return response()->json(['success' => 'Blog has been added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        $data = $blog;
        $data['comments'] = $blog->comments;
        $data['user'] = $blog->user;
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $credentials = [
            'title' => $request->input('title'),
            'content' => $request->input('content'),
        ];

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $blog->update($credentials);

        return response()->json(['success' => 'Blog has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return response()->json(['success' => 'Blog has been deleted successfully']);
    }
}
