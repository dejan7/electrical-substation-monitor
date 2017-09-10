<?php

Auth::routes();
Route::get('/', 'MonitorController@index');
Route::get('/users', 'UsersController@index');
Route::get('/users/new', 'UsersController@getCreateUser');
Route::post('/users/new', 'UsersController@postCreateUser');
Route::get('/users/{id}', 'UsersController@getUser');
Route::post('/users/{id}', 'UsersController@postUpdateUser');

Route::get('/queries', 'QueriesController@index');

