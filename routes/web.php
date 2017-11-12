<?php

/** Application */
Route::get('/subscribers', 'SubscribersController@all')->name('subscribers.all');
Route::delete('/subscriber/{id}', 'SubscribersController@delete')->name('subscribers.delete');

/** Bot */
Route::any('/bot', 'BotController@handle')->name('bot.handle');
Route::post('/bot/broadcast', 'BotController@broadcast')->name('bot.broadcast');

/** Render single view */
Route::view('/{path?}', 'app')
    ->where('path', '.*')
    ->name('view');