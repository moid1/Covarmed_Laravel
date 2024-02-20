<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IncidentsController;
use App\Http\Controllers\KitsController;
use App\Http\Controllers\PreventionAdvisorController;
use App\Http\Controllers\QuestionController;
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
Route::get('register-preventional-advisor/{id}', [PreventionAdvisorController::class, 'showRegisterFormViaMail'])->name('prevention.advisor.showregisterformviamail');
Route::post('register-preventional-advisor', [PreventionAdvisorController::class, 'updateViaEmail'])->name('prevention.advisor.updateviamail');

Route::group(['middleware' => ['auth']], function () {
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

    //kits
    Route::get('/kits', [KitsController::class, 'index'])->name('kits.index');
    Route::get('/kit/{id}', [KitsController::class, 'show'])->name('kits.show');
    Route::put('/kit', [KitsController::class, 'update'])->name('kits.update');
    Route::get('/add-kit', [KitsController::class, 'create'])->name('kits.create');
    Route::post('/kit', [KitsController::class, 'store'])->name('kits.store');
    Route::get('kit-status/{id}', [KitsController::class, 'updateKitStatus'])->name('kits.status');
    Route::get('download-qr/{id}', [KitsController::class, 'downloadQr'])->name('kit.qr.download');
    Route::get('export-kits', [KitsController::class, 'exportKits'])->name('export.kits');
    Route::post('import-kits', [KitsController::class, 'importKits'])->name('import.kits');

    Route::get('/incidents', [IncidentsController::class, 'index'])->name('incident.index');
    Route::get('/incident/{id}', [IncidentsController::class, 'show'])->name('incident.show');
    Route::get('/export-incident/{id}', [IncidentsController::class,'exportIncidentReport'])->name('incident.export');
    Route::get('export-incidents', [IncidentsController::class, 'exportIncidents'])->name('export.incidents');


    //Questions
    Route::get('/questions', [QuestionController::class, 'index'])->name('question.index');
    Route::post('/question', [QuestionController::class, 'store'])->name('question.store');
    Route::get('/question', [QuestionController::class, 'create'])->name('question.create');

    Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
    Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');

    Route::get('chart-filter/{year}', [HomeController::class, 'getCompaniesIncidentByYear'])->name('chart.incidents.companies');
    Route::post('pie-chart-filter', [HomeController::class, 'getCompanyIncidentsReported'])->name('chart.incidents.company');
    // PREVENTIONAL ADVISOR
    Route::get('pv-chart-filter/{year}', [HomeController::class, 'getIncidentsReportedByMonthForPVForYear']);

    Route::get('preventional-advisors/{companyId}', [KitsController::class, 'getPreventionalAdvisorsForCompany']);
});

Route::get('incident-kit/{code}', [IncidentsController::class, 'createIncidentForm'])->name('incident.createform');
Route::post('submit-incident', [IncidentsController::class, 'submitIncident'])->name('incident.submit');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post'); 
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
})->name('language');