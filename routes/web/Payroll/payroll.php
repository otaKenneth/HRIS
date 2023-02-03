<?php

Route::prefix('Payroll')->group(function () {
    Route::get('Computation', 'Payroll\ComputationController@index');
    Route::get('Process', 'Payroll\ComputationController@process');
    Route::get('PaySlip', 'Payroll\PayslipController@index');
    
    
    Route::get('Settings', 'Payroll\SettingController@index');
    Route::patch('Settings', 'Payroll\SettingController@update');

});