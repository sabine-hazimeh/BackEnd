<?php
use App\Http\Controllers\CodeController;
use App\Models\Code;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




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


