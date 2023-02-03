<?php

Route::prefix('Holiday')->group(function () {
    Route::get('', 'HolidayController@index');
    Route::post('', 'HolidayController@store');

    Route::prefix('{holiday}')->group(function () {
        Route::patch('', 'HolidayController@update');
        Route::delete('', 'HolidayController@destroy');
    });
});