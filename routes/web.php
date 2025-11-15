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

// ---------------------- Authentication Routes ----------------------

Route::middleware(['guest', 'throttle:10,1'])->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LogoutController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ---------------------- Language Switcher ----------------------
// Keep this EXACTLY like your old code so switching language still works
Route::get('language/{locale}', [LanguageController::class, 'switch'])
    ->name('language.switch');

// ---------------------- Frontend Routes ----------------------

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// ---------------------- Services ----------------------

Route::get('/services', [LoanServiceController::class, 'index'])
    ->name('services.index');

Route::get('/services/{slug}', [LoanServiceController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')   // security: only simple slugs
    ->name('services.show');

// ---------------------- Quick Contact ----------------------

Route::get('/quick-contact', [ContactController::class, 'quickContactForm'])
    ->name('quick-contact.form');

Route::post('/quick-contact', [ContactController::class, 'quickContactStore'])
    ->middleware('throttle:20,1')       // security: limit spam
    ->name('quick-contact.store');

// ---------------------- Blog ----------------------

Route::get('/blog', [FrontendBlogController::class, 'index'])
    ->name('blog.index');

Route::get('/blog/{slug}', [FrontendBlogController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('blog.show');

// ---------------------- Career ----------------------

Route::get('/career', [CareerController::class, 'index'])
    ->name('career.index');

Route::get('/career/{slug}', [CareerController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('career.show');

Route::post('/career/{slug}/apply', [CareerController::class, 'apply'])
    ->middleware('throttle:10,1')       // security: limit CV spam
    ->where('slug', '[A-Za-z0-9\-]+')
    ->name('career.apply');


// ---------------------- Complaint ----------------------

Route::get('/complaint', [ContactController::class, 'complaintForm'])
    ->name('complaint.form');

Route::post('/complaint', [ContactController::class, 'complaintStore'])
    ->middleware('throttle:10,1')
    ->name('complaint.store');

// ---------------------- Admin Routes ----------------------

Route::prefix('admin')
    ->middleware(['auth','role:admin,superadmin,sale,marketing','throttle:120,1'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Customers (for all admitted roles; policy restricts actions)
        Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)
            ->except(['show']);

        Route::patch('customers/{customer}/complete', [\App\Http\Controllers\Admin\CustomerController::class, 'complete'])
            ->name('customers.complete');

        Route::post('customers/{customer}/share', [\App\Http\Controllers\Admin\CustomerController::class, 'share'])
            ->name('customers.share');

        // Existing admin resources:
        Route::resource('loan-types', App\Http\Controllers\Admin\LoanTypeController::class);
        Route::resource('blogs', App\Http\Controllers\Admin\BlogController::class);
        Route::resource('jobs', App\Http\Controllers\Admin\JobController::class);

        Route::get('job-applications', [App\Http\Controllers\Admin\JobController::class, 'applications'])
            ->name('job-applications');

        Route::patch('job-applications/{application}', [App\Http\Controllers\Admin\JobController::class, 'updateApplicationStatus'])
            ->name('job-applications.update');

        Route::resource('complaints', App\Http\Controllers\Admin\ComplaintController::class);

        Route::post('complaints/{complaint}/respond', [App\Http\Controllers\Admin\ComplaintController::class, 'respond'])
            ->name('complaints.respond');

        Route::resource('slideshows', App\Http\Controllers\Admin\SlideshowController::class);

        Route::get('messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])
            ->name('messages.index');

        Route::patch('messages/{message}/mark-read', [App\Http\Controllers\Admin\ContactMessageController::class, 'markAsRead'])
            ->name('messages.mark-read');

        Route::delete('messages/{message}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])
            ->name('messages.destroy');
    });
