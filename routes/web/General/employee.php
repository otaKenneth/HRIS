<?php


Route::get('/Employees', 'EmployeeController@index');

Route::prefix('Employee')->group(function () {
    Route::get('Create', 'EmployeeController@create');
    Route::get('Export/{ids}', 'EmployeeController@export');
    Route::post('Import', 'EmployeeController@import');
    
    Route::get('getEmployeeNames', 'EmployeeController@getEmployeeNames');

    Route::post('Basic_Info', 'EmployeeController@store_basicInfo');
    
    Route::prefix('{employee}')->group(function () {
        Route::get('Edit', 'EmployeeController@edit')->name('employee.edit');
        Route::get('getLeaveCredits', 'EmployeeController@getLeaveCredits');

        Route::post('Basic_Info', 'EmployeeController@update_basicInfo')->name('employee.basic_info.update');
        Route::post('Profile', 'EmployeeController@update_profile')->name('employee.basic_info.update');
        Route::post('Contact_Info', 'EmployeeController@update_contactInfo')->name('employee.contact_info.update');
        Route::post('Job_info', 'EmployeeController@update_jobInfo')->name('employee.job_info.update');
        Route::post('Employee_Status', 'EmployeeController@update_empStat')->name('employee.empstats.update');
    
        Route::post('Address', 'UserAddressController@store')->name('employee.address.store');
        Route::post('Address/{address}/Edit', 'UserAddressController@update')->name('employee.address.update');
    });
});