<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AuthController;
use App\Models\Chat;
use App\Http\Controllers\CodeController;
use App\Models\Code;



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

Route::get('/users', [ChatController::class, 'getAllUsers']);


// Route::group([
//     // "middleware" => "authenticate",
//     "prefix" => "code",
//     "controller" => CodeController::class
// ], function () {
//     Route::get('/', 'getAllCode');
//     Route::get('/{id}', 'getCode');
//     Route::post('/', 'createCode');
//     Route::delete('/{id}', 'deleteCode');
//     Route::put('/{id}', 'updateCode');
// });

Route::group([
    // "middleware" => "authenticate",
    "prefix" => "code",
    "controller" => CodeController::class
], function () {
    Route::get('/', 'getAllCode');
    Route::get('/{id}', 'getCode');
    Route::post('/', 'createCode');
    Route::delete('/{id}', 'deleteCode');
    Route::put('/{id}', 'updateCode');
});


