<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//auth

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//groups necesita un token para acceder a esos endpoints
Route::group([
'middleware' => 'jwt.auth'
], function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', [AuthController::class, 'profile']);
});



Route::get('/contacts', [ContactController::class, 'getAllContacts']);

Route::get('/contacts/{id}', [ContactController::class, 'getContactById']);

Route::post('/contacts', [ContactController::class, 'createContact']);

Route::put('/contacts/{id}', [ContactController::class, 'updateContact']);

Route::delete('/contacts/{id}', [ContactController::class, 'deleteContact']);

// USER
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/user-by-contact-id/{id}', [UserController::class, 'getUserByContactId']);
});

Route::post('/create-user-admin/{id}', [UserController::class, 'createUserAdmin']);
Route::post('/destroy-user-admin/{id}', [UserController::class, 'destroyUserAdmin']);