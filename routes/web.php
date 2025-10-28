<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

Route::get('/auth/check', function () {
    return response()->json([
        'authenticated' => auth()->check(),
        'user' => auth()->check() ? [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email
        ] : null
    ]);
})->name('auth.check');

Route::get('/templates', [ResumeController::class, 'showTemplates'])->name('templates.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/resume', [ResumeController::class, 'index'])->name('resume.index');
    Route::post('/resume/download', [ResumeController::class, 'download'])->name('resume.download');
    Route::post('/resume/save', [ResumeController::class, 'save'])->name('resume.save');
    Route::post('/resume/preview', [ResumeController::class, 'preview'])->name('resume.preview');
    Route::get('/resume/draft', [ResumeController::class, 'getDraft'])->name('resume.draft');
    
    Route::get('/api/templates', [ResumeController::class, 'getTemplates'])->name('templates.get');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
