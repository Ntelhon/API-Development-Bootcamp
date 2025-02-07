<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function showBlogs()
    {
        $blogs = Blog::with('user')->get();
        return response()->json($blogs);
    }

    public function createBlog(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string'
        ]);

        $blog = Blog::create([
            'user_id' => $request->user()->id,
            'title' => $validate['title'],
            'content' => $validate['content']
        ]);

        return response()->json([
            'message' => 'Blog created successfully',
            'blog' => $blog
        ]);
    }

    public function deleteBlog(Request $request)
    {
        $validate = $request->validate([
            'blog_id' => 'required'
        ]);

        $blog = Blog::where('id', $validate['blog_id'])->first();

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], 404);
        }

        if ($blog->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $blog->delete();

        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
