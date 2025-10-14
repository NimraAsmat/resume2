<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/resume', [ResumeController::class, 'index'])->name('resume.index');
Route::post('/resume/download', [ResumeController::class, 'download'])->name('resume.download');