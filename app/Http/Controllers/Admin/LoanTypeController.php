<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanType;
use App\Models\LoanTypeTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LoanTypeController extends Controller
{
    public function index()
    {
        $loanTypes = LoanType::with('translations.language')->orderBy('order')->paginate(10);
        return view('admin.loan-types.index', compact('loanTypes'));
    }

    public function create()
    {
        $languages = Language::active()->get();
        return view('admin.loan-types.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug'   => 'required|unique:loan_types,slug',
            'icon'   => 'required|string',
            'order'  => 'required|integer',
            'status' => 'required|in:active,inactive',
            'poster' => 'nullable|image|max:3072|dimensions:min_width=1280,min_height=1280' // 3MB
        ]);

        $loanType = new LoanType($validated);

        // Poster upload
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $name = time() . '_' . Str::slug($request->slug) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/services'), $name);
            $loanType->poster = $name;
        }

        $loanType->save();

        // Translations
        $languages = Language::active()->get();
        foreach ($languages as $language) {
            LoanTypeTranslation::create([
                'loan_type_id' => $loanType->id,
                'language_id'  => $language->id,
                'title'        => $request->input("title_{$language->code}"),
                'description'  => $request->input("description_{$language->code}"),
                'conditions'   => $request->input("conditions_{$language->code}"),
            ]);
        }

        return redirect()->route('admin.loan-types.index')
            ->with('success', 'Loan type created successfully');
    }

    public function edit(LoanType $loanType)
    {
        $loanType->load('translations.language');
        $languages = Language::active()->get();
        return view('admin.loan-types.edit', compact('loanType', 'languages'));
    }

    public function update(Request $request, LoanType $loanType)
    {
        $validated = $request->validate([
            'slug'   => "required|unique:loan_types,slug,{$loanType->id}",
            'icon'   => 'required|string',
            'order'  => 'required|integer',
            'status' => 'required|in:active,inactive',
            'poster' => 'nullable|image|max:3072|dimensions:min_width=1280,min_height=1280',
            'poster_remove' => 'nullable|boolean',
        ]);

        $loanType->fill($validated);

        // Poster removal
        if ($request->boolean('poster_remove') && $loanType->poster) {
            @unlink(public_path('uploads/services/' . $loanType->poster));
            $loanType->poster = null;
        }

        // Poster upload
        if ($request->hasFile('poster')) {
            if ($loanType->poster) {
                @unlink(public_path('uploads/services/' . $loanType->poster));
            }
            $file = $request->file('poster');
            $name = time() . '_' . Str::slug($request->slug ?? $loanType->slug) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/services'), $name);
            $loanType->poster = $name;
        }

        $loanType->save();

        // Translations
        $languages = Language::active()->get();
        foreach ($languages as $language) {
            $data = [
                'title'       => $request->input("title_{$language->code}"),
                'description' => $request->input("description_{$language->code}"),
                'conditions'  => $request->input("conditions_{$language->code}"),
            ];

            $loanType->translations()->updateOrCreate(
                ['language_id' => $language->id],
                $data
            );
        }

        return redirect()->route('admin.loan-types.index')
            ->with('success', 'Loan type updated successfully');
    }

    public function destroy(LoanType $loanType)
    {
        if ($loanType->poster) {
            @unlink(public_path('uploads/services/' . $loanType->poster));
        }
        $loanType->delete();
        return redirect()->route('admin.loan-types.index')
            ->with('success', 'Loan type deleted successfully');
    }
}
