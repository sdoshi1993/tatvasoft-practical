<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;


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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',[EventController::class,'index'])->name('event-list');
Route::get('/add-event',[EventController::class,'addEvents'])->name('add-event');
Route::get('/event/{id}',[EventController::class,'addEvents'])->name('edit-event');
Route::get('/delete-event/{id}',[EventController::class,'deleteEvent'])->name('delete-event');
Route::post('/add-event',[EventController::class,'handlePost'])->name('handle-post');
Route::get('/view/{id}',[EventController::class,'viewEvent'])->name('view-event');
