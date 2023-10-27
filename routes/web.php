<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\absenceController;
use App\Http\Controllers\filiereController;
use App\Http\Controllers\stagaireController;
use App\Http\Controllers\sectionController;
use App\Http\Controllers\ArchiveStgController;
use App\Http\Controllers\generalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;










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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['role'])->group(function () {
    Route::resource('/', dashboardController::class);
    Route::resource('Dash', dashboardController::class);
    Route::resource('Abs', absenceController::class);
    Route::resource('Stg', stagaireController::class);
    Route::resource('Sec', sectionController::class);
    Route::resource('Fil', filiereController::class);
    Route::resource('ArchStg', ArchiveStgController::class);
    Route::resource('Profile', ProfileController::class);

    Route::get('/get-stagiaires', [absenceController::class, 'getStagiaires']);
    Route::get('/export-data', [absenceController::class, 'export'])->name('export-data');
    Route::get('/export-Stagiaires', [stagaireController::class, 'export'])->name('export-Stagiaires');
    Route::get('/export-Stagiaires-archive', [ArchiveStgController::class, 'export'])->name('export-Stagiaires-archive');
    Route::get('/export-filieres', [filiereController::class, 'export'])->name('export-filieres');
    Route::get('/export-section', [sectionController::class, 'export'])->name('export-section');
    Route::get('/search', [generalController::class, 'index'])->name('search');
});

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', [UserController::class, 'showLoginForm']);
    Route::post('/auth/login', [UserController::class, 'login'])->name('login');
});


Route::post('/auth/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware('admin')->group(function () {
    // route for mailing

    Route::get('/email', [ProfileController::class, 'email'])->name('email');
    Route::get('Profile/editAdmin/{id}', [ProfileController::class, 'editAdmin'])->name('editAdmin');
    Route::post('Profile/updateAdmin/{id}', [ProfileController::class, 'updateAdmin'])->name('updateAdmin');
});
