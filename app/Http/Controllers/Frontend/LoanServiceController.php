<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LoanType;

class LoanServiceController extends Controller
{
    public function index()
    {
        $loanTypes = LoanType::where('status', 'active')
            ->with(['translations.language'])
            ->orderBy('order')
            ->get();

        return view('frontend.services.index', compact('loanTypes'));
    }

    public function show($slug)
    {
        $loanType = LoanType::where('slug', $slug)

            ->where('status', 'active')
            ->with(['translations.language', 'conditions', 'collateralTypes'])
            ->firstOrFail();

        return view('frontend.services.show', compact('loanType'));
    }
}
