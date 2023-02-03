<?php

Route::prefix('DTR')->group(function () {
    Route::get('', 'DailyTimeRecordController@index');
    Route::prefix('{employee}')->group(function () {
        Route::get('', 'DailyTimeRecordController@show')->middleware('can:view,employee');
        Route::patch('', 'DailyTimeRecordController@update');
    });
    Route::get('{date}/Employee/{employee}/Process', 'DailyTimeRecordController@process');
});