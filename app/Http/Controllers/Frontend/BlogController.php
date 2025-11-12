<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->paginate(9);

        $categories = BlogCategory::where('status', 'active')
            ->withCount('posts')
            ->get();

        return view('frontend.blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with(['category', 'author'])
            ->firstOrFail();

        $post->incrementViews();

        $relatedPosts = BlogPost::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts'));
    }
}
