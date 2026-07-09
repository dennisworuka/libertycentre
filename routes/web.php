<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\ComplianceController;
use App\Http\Controllers\Public\DownloadController;
use App\Http\Controllers\Public\EasyReadController;
use App\Http\Controllers\Public\FaqController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\ServiceController;
use App\Http\Controllers\Public\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/about', [PageController::class, 'about'])->name('about.show');
Route::get('/about/mission-vision-values', [PageController::class, 'missionVisionValues'])->name('about.mission');
Route::get('/about/our-team', TeamController::class)->name('team.index');
Route::get('/faqs', FaqController::class)->name('faqs.index');
Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads.index');
Route::get('/easy-read', EasyReadController::class)->name('easy-read.index');
foreach ([
    'privacy-policy',
    'cookie-policy',
    'safeguarding-statement',
    'complaints-procedure',
    'whistleblowing-statement',
    'modern-slavery-statement',
    'equality-diversity-inclusion',
    'accessibility-statement',
] as $complianceSlug) {
    Route::get('/' . $complianceSlug, [ComplianceController::class, 'show'])
        ->defaults('slug', $complianceSlug)
        ->name('compliance.' . $complianceSlug);
}
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
