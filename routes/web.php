<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BlogContorller;
use App\Http\Controllers\FomoController;
use App\Http\Controllers\ProfileController;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// ROute for subdomain
// URL::forceScheme('https');
Route::domain('portfolio.'.env('APP_URL'))->group(function () {
    Route::get('/', function () {
        return view('portfolio');
    });
});

Route::get('cctv-map', function (Request $request) {
    return view('cctv-map');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-print', function () {
    return view('test-print');
});
Route::get('/printd', function () {
    return view('print');
});
Route::get('/snapshots/{date?}', function (?string $date = null) {
    if(!$date)
    {
        $dirs = Storage::disk('public')->directories(('capture'));
        rsort($dirs);
        return view('snapshots.index', compact('dirs'));
    } else {
        // check if the date directory exists
        $exists = Storage::disk('public')->exists('capture/'.$date);
        if($exists) {
            $files = Storage::disk('public')->allFiles('capture/'.$date);
            return view('snapshots.files', compact('files', 'date'));
        }
    }

});

Route::get('health', HealthCheckResultsController::class);

Route::get('/reset-galon', function () {
    Storage::disk('local')->put('cart-count.json', '0');
});

Route::get('/yourstruly', function () {
    return view('yourstruly');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/typing', function () {
    return view('typing');
})->name('typing');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/blog', [BlogContorller::class, 'index'])->name('blog');

Route::prefix('fomo')->group(function () {
    Route::get('/company', [FomoController::class, 'companyReview'])->name('fomo.company.index');
    Route::get('/company/{activityId}', [FomoController::class, 'companyComments'])->name('fomo.company.showComments');
});

require __DIR__.'/auth.php';
