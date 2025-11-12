<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slideshow;
use App\Models\LoanType;
use App\Models\Page;

class HomeController extends Controller
{
    public function index()
    {
        $slideshows = Slideshow::where('status', 'active')
            ->orderBy('order')
            ->get();

        $loanTypes = LoanType::where('status', 'active')
            ->orderBy('order')
            ->get();

        return view('frontend.home', compact('slideshows', 'loanTypes'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about-us')
            ->where('status', 'active')
            ->first();

        return view('frontend.about', compact('page'));
    }
}
