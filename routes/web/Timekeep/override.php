<?php

Route::prefix('Override')->group(function () {
    Route::get('', 'OverrideController@index');
    Route::post('', 'OverrideController@store');

    Route::get('{employee}', 'OverrideController@show')->middleware('can:view,employee');

    Route::prefix('{override}')->group(function () {
        Route::patch('', 'OverrideController@update');
        Route::patch('status', 'OverrideController@update_status');
    });
});