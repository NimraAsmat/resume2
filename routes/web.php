<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\TemplateController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/resume', [ResumeController::class, 'index'])->name('resume.index');
Route::post('/resume/download', [ResumeController::class, 'download'])->name('resume.download');
Route::post('/resume/save', [ResumeController::class, 'save'])->name('resume.save');
Route::post('/resume/preview', [ResumeController::class, 'preview'])->name('resume.preview');
Route::get('/resume/draft', [ResumeController::class, 'getDraft'])->name('resume.draft');
Route::get('/templates', [ResumeController::class, 'getTemplates'])->name('templates.get');