<?php

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

use App\Http\Middleware\Hellomiddleware;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/e_learning2/{any}', function() {
    return view('e_learning2/index');
})->where('any', '.*');
