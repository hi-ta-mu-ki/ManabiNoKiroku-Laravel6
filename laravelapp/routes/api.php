<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/e_learning2/login', 'Auth\LoginController@login')->name('login');
Route::post('/e_learning2/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/e_learning2/user', fn () => Auth::user())->name('user');
Route::get('/e_learning2/tc/{id}', 'E_learning2Controller@show');
Route::post('/e_learning2/tc', 'E_learning2Controller@store');
Route::post('/e_learning2/tc/import', 'E_learning2Controller@question_import');
Route::post('/e_learning2/tc/import2', 'E_learning2Controller@question_import2');
Route::post('/e_learning2/tc/upload', 'E_learning2Controller@upload');
Route::put('/e_learning2/tc/{id}', 'E_learning2Controller@update');
Route::delete('/e_learning2/tc/{id}', 'E_learning2Controller@destroy');
Route::get('/e_learning2/tc_menu/{e_groups_id}', 'E_learning2Controller@tc_menu');
Route::get('/e_learning2/tc_menu2/{e_classes_id}', 'E_learning2Controller@tc_menu2');
Route::get('/e_learning2/tc/{e_groups_id}/{no}', 'E_learning2Controller@list');
Route::get('/e_learning2/tc/answer/{e_groups_id}/{no}', 'E_learning2Controller@answer_list');
Route::get('/e_learning2/groups_menu', 'E_learning2Controller@groups_menu');
Route::get('/e_learning2/classes_menu', 'E_learning2Controller@classes_menu');
Route::get('/e_learning2/owner_list/{e_groups_id}', 'E_learning2Controller@owner_list');
Route::delete('/e_learning2/owner_list/{user_id}', 'E_learning2Controller@owner_list_delete');
Route::get('/e_learning2/member_list/{e_classes_id}', 'E_learning2Controller@member_list');
Route::delete('/e_learning2/member_list/{user_id}', 'E_learning2Controller@member_list_delete');
Route::get('/e_learning2/tc_select/{e_classes_id}', 'E_learning2Controller@select_title');
Route::put('/e_learning2/tc_setting/{e_classes_id}', 'E_learning2Controller@setting');
Route::get('/e_learning2/group', 'E_learning2Controller@group_index');
Route::get('/e_learning2/group/{id}', 'E_learning2Controller@group_show');
Route::post('/e_learning2/group', 'E_learning2Controller@group_store');
Route::put('/e_learning2/group/{id}', 'E_learning2Controller@group_update');
Route::delete('/e_learning2/group/{id}', 'E_learning2Controller@group_destroy');
Route::get('/e_learning2/class_list/{e_groups_id}', 'E_learning2Controller@class_index');
Route::get('/e_learning2/class/{id}', 'E_learning2Controller@class_show');
Route::post('/e_learning2/class', 'E_learning2Controller@class_store');
Route::put('/e_learning2/class/{id}', 'E_learning2Controller@class_update');
Route::delete('/e_learning2/class/{id}', 'E_learning2Controller@class_destroy');
Route::get('/e_learning2/st_menu/{e_classes_id}', 'E_learning2Controller@st_menu');
Route::get('/e_learning2/st/{e_classes_id}/{no}', 'E_learning2Controller@rdm_list');
Route::get('/e_learning2/st/rand/{a_ptn}', 'E_learning2Controller@a_ptn');
Route::post('/e_learning2/st/answer', 'E_learning2Controller@answer_record');
Route::get('/e_learning2/st/answer/{id}/{e_classes_id}', 'E_learning2Controller@answer_list2');
Route::delete('/e_learning2/st/answer/{id}', 'E_learning2Controller@answer_delete');
Route::get('/e_learning2/group_join', 'E_learning2Controller@group_user_index');
Route::post('/e_learning2/group_join/{e_groups_id}', 'E_learning2Controller@group_join');
Route::get('/e_learning2/class_join1', 'E_learning2Controller@class_user_index');
Route::post('/e_learning2/class_join1/{e_classes_id}', 'E_learning2Controller@class_join1');
Route::post('/e_learning2/class_join2', 'E_learning2Controller@class_join2');
Route::get('/e_learning2/ad', 'E_learning2Controller@user_index');
Route::get('/e_learning2/ad/{id}', 'E_learning2Controller@user_show');
Route::post('/e_learning2/ad', 'E_learning2Controller@user_store');
Route::post('/e_learning2/ad/import', 'E_learning2Controller@user_import');
Route::post('/e_learning2/ad/import2', 'E_learning2Controller@user_import2');
Route::put('/e_learning2/ad/{id}', 'E_learning2Controller@user_update');
Route::delete('/e_learning2/ad/{id}', 'E_learning2Controller@user_destroy');
Route::get('/e_learning2/reflesh-token', function (Illuminate\Http\Request $request) {
  $request->session()->regenerateToken();
  return response()->json();
});
