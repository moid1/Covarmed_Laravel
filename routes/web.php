<?php

use App\Http\Controllers\IncidentsController;
use App\Http\Controllers\KitsController;
use App\Http\Controllers\PreventionAdvisorController;
use App\Models\PreventionAdvisor;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/prevention-advisor', [PreventionAdvisorController::class, 'index'])->name('prevention.advisor.index');
Route::get('/add-prevention-advisor', [PreventionAdvisorController::class, 'create'])->name('prevention.advisor.create');
Route::get('/prevention-advisor/{id}', [PreventionAdvisorController::class, 'show'])->name('prevention.advisor.show');
Route::post('/prevention-advisor', [PreventionAdvisorController::class, 'store'])->name('prevention.advisor.store');
Route::put('/prevention-advisor/{id}', [PreventionAdvisorController::class, 'update'])->name('prevention.advisor.update');
Route::get('/delete-preventional-advisor/{id}', [PreventionAdvisorController::class, 'destroy'])->name('prevention.advisor.delete');
//kits
Route::get('/kits', [KitsController::class, 'index'])->name('kits.index');
Route::get('/add-kit', [KitsController::class, 'create'])->name('kits.create');
Route::post('/kit', [KitsController::class, 'store'])->name('kits.store');
// Route::get('/download-qr/{id}', [KitsController::class, 'downloadQR'])->name('kits.download.qr');

Route::get('/incidents', [IncidentsController::class,'index'])->name('incident.index');


Route::get('incident-kit/{code}', [IncidentsController::class, 'createIncidentForm'])->name('incident.createform');
Route::post('submit-incident', [IncidentsController::class, 'submitIncident'])->name('incident.submit');