<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slideshow;
use App\Models\SlideshowTranslation;
use App\Models\Language;
use Illuminate\Http\Request;

class SlideshowController extends Controller
{
    public function index()
    {
        $slideshows = Slideshow::with('translations')
            ->orderBy('order')
            ->paginate(10);

        return view('admin.slideshows.index', compact('slideshows'));
    }

    public function create()
    {
        $languages = Language::where('status', 'active')->get();
        return view('admin.slideshows.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|max:2048',
            'link' => 'nullable|url',
            'order' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'title_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'button_text_en' => 'nullable|string|max:255',
            'title_km' => 'required|string|max:255',
            'description_km' => 'nullable|string',
            'button_text_km' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/slideshows'), $imageName);

        $slideshow = Slideshow::create([
            'image' => $imageName,
            'link' => $validated['link'],
            'order' => $validated['order'],
            'status' => $validated['status'],
        ]);

        // Create translations
        $enLang = Language::where('code', 'en')->first();
        SlideshowTranslation::create([
            'slideshow_id' => $slideshow->id,
            'language_id' => $enLang->id,
            'title' => $validated['title_en'],
            'description' => $validated['description_en'],
            'button_text' => $validated['button_text_en'],
        ]);

        $kmLang = Language::where('code', 'km')->first();
        SlideshowTranslation::create([
            'slideshow_id' => $slideshow->id,
            'language_id' => $kmLang->id,
            'title' => $validated['title_km'],
            'description' => $validated['description_km'],
            'button_text' => $validated['button_text_km'],
        ]);

        return redirect()->route('admin.slideshows.index')
            ->with('success', 'Slideshow created successfully');
    }

    public function edit(Slideshow $slideshow)
    {
        $languages = Language::where('status', 'active')->get();
        $slideshow->load('translations');

        return view('admin.slideshows.edit', compact('slideshow', 'languages'));
    }

    public function update(Request $request, Slideshow $slideshow)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'order' => 'required|integer',
            'status' => 'required|in:active,inactive',
            'title_en' => 'required|string|max:255',
            'description_en' => 'nullable|string',
            'title_km' => 'required|string|max:255',
            'description_km' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if (file_exists(public_path('uploads/slideshows/' . $slideshow->image))) {
                unlink(public_path('uploads/slideshows/' . $slideshow->image));
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/slideshows'), $imageName);
            $validated['image'] = $imageName;
        }

        $slideshow->update([
            'image' => $validated['image'] ?? $slideshow->image,
            'link' => $validated['link'],
            'order' => $validated['order'],
            'status' => $validated['status'],
        ]);

        // Update translations
        $enLang = Language::where('code', 'en')->first();
        $slideshow->translations()->where('language_id', $enLang->id)->update([
            'title' => $validated['title_en'],
            'description' => $validated['description_en'],
        ]);

        $kmLang = Language::where('code', 'km')->first();
        $slideshow->translations()->where('language_id', $kmLang->id)->update([
            'title' => $validated['title_km'],
            'description' => $validated['description_km'],
        ]);

        return redirect()->route('admin.slideshows.index')
            ->with('success', 'Slideshow updated successfully');
    }

    public function destroy(Slideshow $slideshow)
    {
        // Delete image
        if (file_exists(public_path('uploads/slideshows/' . $slideshow->image))) {
            unlink(public_path('uploads/slideshows/' . $slideshow->image));
        }

        $slideshow->delete();

        return redirect()->route('admin.slideshows.index')
            ->with('success', 'Slideshow deleted successfully');
    }
}
