<?php

/** Application */
Route::view('/', 'subscribers');
Route::view('/broadcast', 'broadcast');

Route::get('/subscribers', 'SubscribersController@all');
Route::delete('/subscriber/{id}', 'SubscribersController@delete');

/** Bot */
Route::match(['get', 'post'], '/bot', 'BotController@handle');
Route::post('/bot/broadcast', 'BotController@broadcast');