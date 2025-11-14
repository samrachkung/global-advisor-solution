<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanType;
use App\Models\LoanTypeTranslation;
use App\Models\LoanCondition;
use App\Models\Language;
use Illuminate\Http\Request;

class LoanTypeController extends Controller
{
    public function index()
    {
        $loanTypes = LoanType::with(['translations.language','conditions'])
            ->orderBy('order')->paginate(10);

        return view('admin.loan-types.index', compact('loanTypes'));
    }

    public function create()
    {
        $languages = Language::active()->get();
        return view('admin.loan-types.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'slug' => 'required|unique:loan_types,slug',
            'icon' => 'required|string',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072|dimensions:min_width=1280,min_height=1280,ratio=1/1',
            'order' => 'required|integer',
            'status' => 'required|in:active,inactive',
            // translations
            'title_en' => 'required|string',
            'description_en' => 'required|string',
            'conditions_en' => 'nullable|string',
            'title_km' => 'required|string',
            'description_km' => 'required|string',
            'conditions_km' => 'nullable|string',
            // conditions
            'currency_type' => 'required|in:USD,KHR,Both',
            'min_amount' => 'required|numeric|min:0',
            'max_amount' => 'required|numeric|gte:min_amount',
            'max_duration_months' => 'required|integer|min:1',
            'min_age' => 'required|integer|min:18',
            'max_age' => 'required|integer|gte:min_age',
            'max_debt_ratio' => 'required|numeric|min:0|max:100',
        ]);

        // Poster
        $poster = null;
        if ($request->hasFile('poster')) {
            $poster = $this->savePoster($request->file('poster'));
        }

        $loanType = LoanType::create([
            'slug' => $data['slug'],
            'icon' => $data['icon'],
            'poster' => $poster,
            'order' => $data['order'],
            'status' => $data['status'],
        ]);

        $en = Language::where('code','en')->firstOrFail();
        $km = Language::where('code','km')->firstOrFail();

        $loanType->translations()->createMany([
            [
                'language_id' => $en->id,
                'title' => $data['title_en'],
                'description' => $data['description_en'],
                'conditions' => $data['conditions_en'] ?? null,
            ],
            [
                'language_id' => $km->id,
                'title' => $data['title_km'],
                'description' => $data['description_km'],
                'conditions' => $data['conditions_km'] ?? null,
            ],
        ]);

        $loanType->conditions()->create([
            'currency_type' => $data['currency_type'],
            'min_amount' => $data['min_amount'],
            'max_amount' => $data['max_amount'],
            'max_duration_months' => $data['max_duration_months'],
            'min_age' => $data['min_age'],
            'max_age' => $data['max_age'],
            'max_debt_ratio' => $data['max_debt_ratio'],
        ]);

        return redirect()->route('admin.loan-types.index')->with('success','Loan Type created.');
    }

    public function show(LoanType $loanType)
    {
        $loanType->load(['conditions','translations.language']);
        return view('admin.loan-types.show', compact('loanType'));
    }

    public function edit(LoanType $loanType)
    {
        $loanType->load('translations.language','conditions');
        $languages = Language::active()->get();
        return view('admin.loan-types.edit', compact('loanType','languages'));
    }

    public function update(Request $request, LoanType $loanType)
    {
        $data = $request->validate([
            'slug' => 'required|unique:loan_types,slug,'.$loanType->id,
            'icon' => 'required|string',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072|dimensions:min_width=1280,min_height=1280,ratio=1/1',
            'poster_remove' => 'nullable|boolean',
            'order' => 'required|integer',
            'status' => 'required|in:active,inactive',
            // translations
            'title_en' => 'required|string',
            'description_en' => 'required|string',
            'conditions_en' => 'nullable|string',
            'title_km' => 'required|string',
            'description_km' => 'required|string',
            'conditions_km' => 'nullable|string',
            // optional condition edits
            'currency_type' => 'nullable|in:USD,KHR,Both',
            'min_amount' => 'nullable|numeric|min:0',
            'max_amount' => 'nullable|numeric|gte:min_amount',
            'max_duration_months' => 'nullable|integer|min:1',
            'min_age' => 'nullable|integer|min:18',
            'max_age' => 'nullable|integer|gte:min_age',
            'max_debt_ratio' => 'nullable|numeric|min:0|max:100',
        ]);

        // Remove poster
        if ($request->boolean('poster_remove') && $loanType->poster) {
            $this->deletePoster($loanType->poster);
            $loanType->poster = null;
        }
        // Replace poster
        if ($request->hasFile('poster')) {
            $loanType->poster = $this->savePoster($request->file('poster'), $loanType->getOriginal('poster'));
        }

        $loanType->fill([
            'slug' => $data['slug'],
            'icon' => $data['icon'],
            'order' => $data['order'],
            'status' => $data['status'],
        ])->save();

        $en = Language::where('code','en')->firstOrFail();
        $km = Language::where('code','km')->firstOrFail();

        $loanType->translations()->updateOrCreate(
            ['language_id' => $en->id],
            ['title' => $request->title_en, 'description' => $request->description_en, 'conditions' => $request->conditions_en]
        );
        $loanType->translations()->updateOrCreate(
            ['language_id' => $km->id],
            ['title' => $request->title_km, 'description' => $request->description_km, 'conditions' => $request->conditions_km]
        );

        if ($request->filled('currency_type')) {
            $loanType->conditions()->updateOrCreate(
                ['loan_type_id' => $loanType->id],
                [
                    'currency_type' => $request->currency_type,
                    'min_amount' => $request->min_amount,
                    'max_amount' => $request->max_amount,
                    'max_duration_months' => $request->max_duration_months,
                    'min_age' => $request->min_age,
                    'max_age' => $request->max_age,
                    'max_debt_ratio' => $request->max_debt_ratio,
                ]
            );
        }

        return redirect()->route('admin.loan-types.index')->with('success','Loan Type updated.');
    }

    public function destroy(LoanType $loanType)
    {
        if ($loanType->poster) {
            $this->deletePoster($loanType->poster);
        }
        $loanType->delete();
        return redirect()->route('admin.loan-types.index')->with('success','Loan type deleted successfully');
    }

    // ------------ File helpers ------------

    private function savePoster(?\Illuminate\Http\UploadedFile $file, ?string $old = null): ?string
    {
        if (!$file) return $old;

        $targetDir = public_path('uploads/services');
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        if ($old) {
            $this->deletePoster($old);
        }

        $ext = strtolower($file->getClientOriginalExtension());
        $name = 'service_' . time() . '_' . uniqid() . '.' . $ext;

        $file->move($targetDir, $name);

        return $name;
    }

    private function deletePoster(string $filename): void
    {
        $path = public_path('uploads/services/' . $filename);
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
