<?php

use App\Http\Controllers\RoomChatController;
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
    return view('welcome');
});

Route::group(['prefix'=>'chat-room'],function (){
    Route::get('/',[RoomChatController::class,'index'])->name('room.index');
    Route::post('/store',[RoomChatController::class,'store'])->name('room.store');
    Route::post('/search/',[RoomChatController::class,'search'])->name('room.search');
    Route::post('/join',[RoomChatController::class,'join'])->name('room.join');
    Route::post('/open',[RoomChatController::class,'open'])->name('room.open');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
