<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LoanServiceController;
use App\Http\Controllers\Frontend\BlogController as FrontendBlogController;
use App\Http\Controllers\Frontend\CareerController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Admin\LoanTypeController;

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Language Switcher
Route::get('language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Services
Route::get('/services', [LoanServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [LoanServiceController::class, 'show'])->name('services.show');


// Blog
Route::get('/blog', [FrontendBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [FrontendBlogController::class, 'show'])->name('blog.show');

// Career
Route::get('/career', [CareerController::class, 'index'])->name('career.index');
Route::get('/career/{slug}', [CareerController::class, 'show'])->name('career.show');
Route::post('/career/{slug}/apply', [CareerController::class, 'apply'])->name('career.apply');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Complaint
Route::get('/complaint', [ContactController::class, 'complaintForm'])->name('complaint.form');
Route::post('/complaint', [ContactController::class, 'complaintStore'])->name('complaint.store');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Loan Types
    Route::resource('loan-types', App\Http\Controllers\Admin\LoanTypeController::class);
    


    // Blog Posts
    Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);

    // Job Positions
    Route::resource('jobs', App\Http\Controllers\Admin\JobController::class);
    Route::get('job-applications', [App\Http\Controllers\Admin\JobController::class, 'applications'])->name('job-applications');
    Route::patch('job-applications/{application}', [App\Http\Controllers\Admin\JobController::class, 'updateApplicationStatus'])->name('job-applications.update');

    // Complaints
    Route::resource('complaints', App\Http\Controllers\Admin\ComplaintController::class);
    Route::post('complaints/{complaint}/respond', [App\Http\Controllers\Admin\ComplaintController::class, 'respond'])->name('complaints.respond');

    // Slideshows
    Route::resource('slideshows', App\Http\Controllers\Admin\SlideshowController::class);

    // Contact Messages
    Route::get('messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('messages/{message}/mark-read', [App\Http\Controllers\Admin\ContactMessageController::class, 'markAsRead'])->name('messages.mark-read');
    Route::delete('messages/{message}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
});
