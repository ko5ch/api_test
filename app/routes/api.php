<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('users')->group(function () {
    Route::get('', [UserController::class, 'users'])->name('users'); // 6
    Route::get('{user}/comments/', [UserController::class, 'comments'])->name('user.comments'); // 7 by Eloquent
    Route::get('{user}/comments_by_builder/', [UserController::class, 'commentsByBuilder']) // 7 by QueryBuilder
        ->name('user.comments_builder');
});