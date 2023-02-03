<?php

Route::prefix('Shift')->group(function () {
    Route::get('', 'ShiftController@index');
    Route::get('list', 'ShiftController@list');
    Route::post('', 'ShiftController@store');

    Route::patch('{shift}', 'ShiftController@update');

    Route::delete('{shift}', 'ShiftController@delete');
});