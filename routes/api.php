<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Models\Chat;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});



Route::group([
    "prefix" => "chats",
    "controller" => ChatController::class
], function () {

    Route::get('/', 'getAllChats');
    Route::get('/{id}',  'getChat');
    Route::post('/', 'createChat');
    Route::delete('/{id}',  'deleteChat');
    Route::put('/{id}',  'updateChat');
    Route::get('/messages/{receiverId}', 'getMessages');
});

