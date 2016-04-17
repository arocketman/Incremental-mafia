<?php

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/family/{id}','HomeController@family');
Route::get('/api/updateIP','HomeController@updateIP');
Route::get('/api/getSoldiersList','SoldiersController@getSoldiersList');
Route::post('/api/newSoldier','SoldiersController@newSoldier');
Route::post('api/deleteSoldier/{soldierID}','SoldiersController@deleteSoldier');
Route::post('/api/redeemBonusIP','HomeController@redeemBonusIP');
Route::auth();