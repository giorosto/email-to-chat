<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function(){
    return view('welcome');
});
Route::post('/send-email', [\App\Http\Controllers\HomeController::class, 'sendEmail'])->name('send-email');
Route::get('/check-imap', [MailController::class, 'getMail']);
Route::get('messages',function(){
    \App\Models\EmailMessage::where('was_replied',1)->update(['was_replied'=>0]);
    return \App\Models\EmailMessage::all();
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
