<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
#use Illuminate\Support\Facades\Debugbar;


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

Route::get('/', function () {
    Log::info('Loading welcome page');
    Debugbar::info('Loading welcome page');   
    return view('welcome');
   

});



use App\Http\Controllers\MailController;
// ...
Route::get('mail/test', [MailController::class, 'test']);
// or
// Route::get('mail/test', 'App\Http\Controllers\MailController@test');

