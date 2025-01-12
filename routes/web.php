<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\Web\ExaminationController;
use App\Http\Controllers\Web\PatientController;
use App\Http\Controllers\Web\DoctorController;
use App\Http\Controllers\Web\DashboardController;

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

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    
    Route::resource('patients', PatientController::class);
    Route::resource('examinations', ExaminationController::class);
    Route::resource('prescriptions', ExaminationController::class);
    
    Route::get('/search-options/patients', [PatientController::class, 'searchOptions']);
    Route::get('/search-options/doctors', [DoctorController::class, 'searchOptions']);

    Route::get('/medicines/fetch', [MedicineController::class, 'getMedicines'])->name('medicines.fetch');
    Route::get('/medicines/{id}/prices', [MedicineController::class, 'getMedicinePrices'])->name('medicines.prices');
});


Auth::routes(); 