<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ImportController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
Route::get('/imports', [ImportController::class, 'index'])->name('imports.index');
Route::get('/imports/create', [ImportController::class, 'create'])->name('imports.create');
Route::post('/store', [ImportController::class, 'store'])->name('imports.store');
Route::get('/imports/verify/{id}', [ImportController::class, 'verify'])->name('imports.verify');
Route::post('/imports/change-status/{id}', [ImportController::class, 'changeStatus'])->name('imports.change-status');
Route::get('/imports/errors/{id}', [ImportController::class, 'errors'])->name('imports.errors');