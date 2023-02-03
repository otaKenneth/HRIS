<?php

Route::prefix('Overtime')->group(function () {
    Route::get('', 'OvertimeController@index');
    Route::post('', 'OvertimeController@store');

    Route::get('{employee}', 'OvertimeController@show')->middleware('can:view,employee');
    
    Route::prefix('{overtime}')->group(function () {
        Route::patch('', 'OvertimeController@update');
        Route::patch('status', 'OvertimeController@update_status');
    });
});