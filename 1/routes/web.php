<?php

use Illuminate\Support\Facades\Route;
use App\Mail\SendMail;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/subscribe/submit', [App\Http\Controllers\SubscriptionController::class, 'submitOrder']);

Route::get('sendMail',function(){
     Mail::to('hasan.kkhan22@gmail.com')->send(new SendMail("hello"));
     return "Send";
});
