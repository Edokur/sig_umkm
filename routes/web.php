<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/map', [MapController::class, 'index'])->middleware(['auth'])->name('map');
Route::post('/add-map', [MapController::class, 'store'])->middleware(['auth']);

// Route::group('middleware', function () {
//     Route::get('/map', [MapController::class, 'index'])->name('map');
//     Route::post('/map/store', [MapController::class, 'store'])->name('map.route');
// });

require __DIR__ . '/auth.php';
