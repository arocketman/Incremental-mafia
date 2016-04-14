<?php
Route::get('/', function () {
    return "hi";
});

Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/family/{id}','HomeController@family');
Route::post('/family/newSoldier','HomeController@newSoldier');
Route::get('/api/updateIP','HomeController@updateIP');
