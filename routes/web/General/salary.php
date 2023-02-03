<?php

Route::prefix('Salary')->group(function () {
    Route::get('', 'SalaryController@index');
    Route::post('', 'SalaryController@store');
    Route::patch('{salary}', 'SalaryController@update');
});