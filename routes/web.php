<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatagisController;
use App\Http\Controllers\DataumkmController;
use App\Http\Controllers\ProfileController;

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

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [MapController::class, 'location'])->name('location');
});

### Start Dashboard
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/profile', [ProfileController::class, 'index']);
    // Route::post('/profile/update', [ProfileController::class, 'update']);
    // Route::post('/profile/changefoto', [ProfileController::class, 'changefoto']);
    // Route::post('/profile/changepassword', [ProfileController::class, 'changepassword']);
});

### End Dashboard
Route::get('/map', [MapController::class, 'index'])->middleware(['auth'])->name('map');
Route::post('/add-map', [MapController::class, 'store'])->middleware(['auth']);

### Start Data UMKM
Route::group(['middleware' => ['auth']], function () {
    Route::get('/data_umkm', [DataumkmController::class, 'index'])->name('data_umkm');
    Route::get('/data_umkm/create', [DataumkmController::class, 'create']);
    Route::post('/data_umkm/store', [DataumkmController::class, 'store'])->name('data_umkm.store');
    Route::post('/data_umkm/detail/{id}', [DataumkmController::class, 'detail'])->name('data_umkm.detail');
    Route::post('/data_umkm/delete/{id}', [DataumkmController::class, 'delete'])->name('data_umkm.delete');
    Route::get('/data_umkm/edit/{id}', [DataumkmController::class, 'edit'])->name('data_umkm.edit');
    Route::post('/data_umkm/update', [DataumkmController::class, 'update'])->name('data_umkm.update');
});
### End Data UMKM

### Start Data GIS
Route::group(['middleware' => ['auth']], function () {
    Route::get('/data_gis', [DatagisController::class, 'index'])->name('data_gis');
});
### End Data GIS

### Start Profile
Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/changepassword', [ProfileController::class, 'changepassword'])->name('changepassword');
});
### END Profile

require __DIR__ . '/auth.php';
