<?php

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

Route::get('/contacts', function(){
    return 'GET ALL CONTACTS';
});

Route::get('/contacts/{id}', function($id){
    return 'GET CONTACT BY ID ->'.$id;
});

Route::post('/contacts', function(Request $request){
    dump($request->all());
    return 'CREATE CONTACT';
});

Route::put('/contacts/{id}', function(){
    return 'UPDATE CONTACT BY ID';
});

Route::delete('/contacts/{id}', function(){
    return 'DELETE CONTACT BY ID';
});