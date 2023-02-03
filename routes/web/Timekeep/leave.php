<?php

Route::prefix('Leave')->group(function () {
    Route::get('', 'LeaveController@index');
    Route::post('', 'LeaveController@store');

    Route::get('{employee}', 'LeaveController@show')->middleware('can:view,employee');

    Route::prefix('{leave}')->group(function () {
        Route::patch('', 'LeaveController@update');
        Route::delete('', 'LeaveController@destroy');
        Route::patch('status', 'LeaveController@update_status');
    });
});