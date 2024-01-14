<?php

use App\Http\Controllers\CompanyController;
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

//Companies

Route::get('/company', [CompanyController::class, 'create'])->name('company.create');
Route::get('/company/{id}', [CompanyController::class, 'show'])->name('company.show');
Route::get('/companies', [CompanyController::class, 'index'])->name('company.index');
Route::post('/company', [CompanyController::class, 'store'])->name('company.store');
Route::post('/update-company', [CompanyController::class, 'update'])->name('company.update');
Route::get('/update-company-status/{id}', [CompanyController::class, 'updateCompanyStatus'])->name('company.update.status');

//Preventinal Advisors
Route::get('/prevention-advisor', [PreventionAdvisorController::class, 'index'])->name('prevention.advisor.index');
Route::get('/add-prevention-advisor', [PreventionAdvisorController::class, 'create'])->name('prevention.advisor.create');
Route::get('/prevention-advisor/{id}', [PreventionAdvisorController::class, 'show'])->name('prevention.advisor.show');
Route::post('/prevention-advisor', [PreventionAdvisorController::class, 'store'])->name('prevention.advisor.store');
Route::put('/prevention-advisor/{id}', [PreventionAdvisorController::class, 'update'])->name('prevention.advisor.update');
Route::get('/delete-preventional-advisor/{id}', [PreventionAdvisorController::class, 'destroy'])->name('prevention.advisor.delete');

Route::get('register-preventional-advisor/{id}', [PreventionAdvisorController::class, 'showRegisterFormViaMail'])->name('prevention.advisor.showregisterformviamail');
Route::post('register-preventional-advisor', [PreventionAdvisorController::class, 'updateViaEmail'])->name('prevention.advisor.updateviamail');
//kits
Route::get('/kits', [KitsController::class, 'index'])->name('kits.index');
Route::get('/add-kit', [KitsController::class, 'create'])->name('kits.create');
Route::post('/kit', [KitsController::class, 'store'])->name('kits.store');
// Route::get('/download-qr/{id}', [KitsController::class, 'downloadQR'])->name('kits.download.qr');

Route::get('/incidents', [IncidentsController::class,'index'])->name('incident.index');


Route::get('incident-kit/{code}', [IncidentsController::class, 'createIncidentForm'])->name('incident.createform');
Route::post('submit-incident', [IncidentsController::class, 'submitIncident'])->name('incident.submit');