<?php

use App\Http\Controllers\ClusterController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataumkmController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VariabelController;

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
    Route::get('/', [MapController::class, 'index'])->name('location');
    Route::get('/filter-locations', [MapController::class, 'filterLocations'])->name('filter.locations');
    Route::get('/get-all-locations', [MapController::class, 'loadallLocations'])->name('loadall.locations');
});

### Start Dashboard
Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
### End Dashboard


### Start Profile
Route::group(['middleware' => ['auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/changepassword', [ProfileController::class, 'changepassword'])->name('changepassword');
});
### END Profile

### Start Data UMKM
Route::group(['middleware' => ['auth']], function () {
    Route::get('/data_umkm', [DataumkmController::class, 'index'])->name('data_umkm');
    Route::get('/data_umkm/create', [DataumkmController::class, 'create']);
    Route::post('/data_umkm/store', [DataumkmController::class, 'store'])->name('data_umkm.store');
    Route::post('/data_umkm/detail/{id}', [DataumkmController::class, 'detail'])->name('data_umkm.detail');
    Route::post('/data_umkm/delete/{id}', [DataumkmController::class, 'delete'])->name('data_umkm.delete');
    Route::get('/data_umkm/edit/{id}', [DataumkmController::class, 'edit'])->name('data_umkm.edit');
    Route::post('/data_umkm/update', [DataumkmController::class, 'update'])->name('data_umkm.update');
    Route::post('/data_umkm/import_excel', [DataumkmController::class, 'import_excel'])->name('data_umkm.import');

    ### Hasil Perhitungan
    Route::get('/hasil', [DataumkmController::class, 'hasil'])->name('hasil');
});
### End Data UMKM

### Start Data Perhitungan Kmeans
Route::group(['middleware' => ['auth']], function () {
    Route::get('/data_kmeans', [PerhitunganController::class, 'index'])->name('data_kmeans');
    Route::post('/data_kmeans/store', [PerhitunganController::class, 'store'])->name('data_kmeans.store');
});
### End Data Perhitungan Kmeans

### Start Data Cluster
Route::group(['middleware' => ['auth']], function () {
    Route::get('/data_cluster', [ClusterController::class, 'index'])->name('data_cluster');
    Route::get('/data_cluster/create', [ClusterController::class, 'create']);
    Route::post('/data_cluster/store', [ClusterController::class, 'store'])->name('data_cluster.store');
    Route::post('/data_cluster/delete/{id}', [ClusterController::class, 'delete'])->name('data_cluster.delete');
    Route::get('/data_cluster/edit/{id}', [ClusterController::class, 'edit'])->name('data_cluster.edit');
    Route::post('/data_cluster/update', [ClusterController::class, 'update'])->name('data_cluster.update');
});
### End Data Cluster

### Start Data Variabel
Route::group(['middleware' => ['auth']], function () {
    Route::get('/data_variabel', [VariabelController::class, 'index'])->name('data_variabel');
    Route::get('/data_variabel/create', [VariabelController::class, 'create']);
    Route::post('/data_variabel/store', [VariabelController::class, 'store'])->name('data_variabel.store');
    Route::post('/data_variabel/delete/{id}', [VariabelController::class, 'delete'])->name('data_variabel.delete');
    Route::get('/data_variabel/edit/{id}', [VariabelController::class, 'edit'])->name('data_variabel.edit');
    Route::post('/data_variabel/update', [VariabelController::class, 'update'])->name('data_variabel.update');
});
### End Data Variabel

require __DIR__ . '/auth.php';
