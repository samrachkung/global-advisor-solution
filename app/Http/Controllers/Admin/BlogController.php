<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogPostTranslation;
use App\Models\BlogCategory;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with(['category', 'author', 'translations'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.blogs.index', compact('posts'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', 'active')->get();
        $languages = Language::where('status', 'active')->get();
        return view('admin.blogs.create', compact('categories', 'languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'slug' => 'required|unique:blog_posts|max:255',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
            'title_en' => 'required|string|max:255',
            'excerpt_en' => 'required|string',
            'content_en' => 'required|string',
            'title_km' => 'required|string|max:255',
            'excerpt_km' => 'required|string',
            'content_km' => 'required|string',
        ]);

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $imageName = time() . '_' . $request->file('featured_image')->getClientOriginalName();
            $request->file('featured_image')->move(public_path('uploads/blogs'), $imageName);
            $validated['featured_image'] = $imageName;
        }

        $post = BlogPost::create([
            'category_id' => $validated['category_id'],
            'author_id' => auth()->id(),
            'slug' => Str::slug($validated['slug']),
            'featured_image' => $validated['featured_image'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['status'] == 'published' ? ($validated['published_at'] ?? now()) : null,
        ]);

        // Create translations
        $enLang = Language::where('code', 'en')->first();
        BlogPostTranslation::create([
            'post_id' => $post->id,
            'language_id' => $enLang->id,
            'title' => $validated['title_en'],
            'excerpt' => $validated['excerpt_en'],
            'content' => $validated['content_en'],
        ]);

        $kmLang = Language::where('code', 'km')->first();
        BlogPostTranslation::create([
            'post_id' => $post->id,
            'language_id' => $kmLang->id,
            'title' => $validated['title_km'],
            'excerpt' => $validated['excerpt_km'],
            'content' => $validated['content_km'],
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully');
    }

    public function edit(BlogPost $blog)
    {
        $categories = BlogCategory::where('status', 'active')->get();
        $languages = Language::where('status', 'active')->get();
        $blog->load('translations');

        return view('admin.blogs.edit', compact('blog', 'categories', 'languages'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:blog_categories,id',
            'slug' => 'required|max:255|unique:blog_posts,slug,' . $blog->id,
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|max:2048',
            'title_en' => 'required|string|max:255',
            'excerpt_en' => 'required|string',
            'content_en' => 'required|string',
            'title_km' => 'required|string|max:255',
            'excerpt_km' => 'required|string',
            'content_km' => 'required|string',
        ]);

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image && file_exists(public_path('uploads/blogs/' . $blog->featured_image))) {
                unlink(public_path('uploads/blogs/' . $blog->featured_image));
            }

            $imageName = time() . '_' . $request->file('featured_image')->getClientOriginalName();
            $request->file('featured_image')->move(public_path('uploads/blogs'), $imageName);
            $validated['featured_image'] = $imageName;
        }

        $blog->update([
            'category_id' => $validated['category_id'],
            'slug' => Str::slug($validated['slug']),
            'featured_image' => $validated['featured_image'] ?? $blog->featured_image,
            'status' => $validated['status'],
            'published_at' => $validated['status'] == 'published' ? ($blog->published_at ?? now()) : null,
        ]);

        // Update translations
        $enLang = Language::where('code', 'en')->first();
        $blog->translations()->where('language_id', $enLang->id)->update([
            'title' => $validated['title_en'],
            'excerpt' => $validated['excerpt_en'],
            'content' => $validated['content_en'],
        ]);

        $kmLang = Language::where('code', 'km')->first();
        $blog->translations()->where('language_id', $kmLang->id)->update([
            'title' => $validated['title_km'],
            'excerpt' => $validated['excerpt_km'],
            'content' => $validated['content_km'],
        ]);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully');
    }

    public function destroy(BlogPost $blog)
    {
        // Delete image
        if ($blog->featured_image && file_exists(public_path('uploads/blogs/' . $blog->featured_image))) {
            unlink(public_path('uploads/blogs/' . $blog->featured_image));
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully');
    }
}
