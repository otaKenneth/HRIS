<?php

Route::prefix('Schedule')->group(function () {
    Route::get('', 'ScheduleController@index');
    Route::get('getUserSchedule/{user}', 'ScheduleController@getUserSchedule');
    Route::post('', 'ScheduleController@store');
    Route::patch('{user}', 'ScheduleController@update');
});