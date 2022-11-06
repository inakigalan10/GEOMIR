<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PlaceController;

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

Route::get('/', function (Request $request) {
    $message = 'Loading welcome page';
    Log::info($message);
    $request->session()->flash('info', $message);
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('mail/test', [MailController::class, 'test']);
 
Route::resource('files', FileController::class);
Route::resource('places', PlaceController::class);

Route::resource('places', PlaceController::class)
        ->middleware(['auth', 'role.any:3,2']);
        
Route::resource('files', FileController::class)
        ->middleware(['auth', 'role.any:3,2']);

// ...

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
