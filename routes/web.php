<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/logout', 'HomeController@logout')->name('logout');

Route::get('/201File/{employee}', 'ProfileController@index');
Route::post('/201File/{employee}/update_password', 'ProfileController@update_password');

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

Route::prefix('Schedule')->group(function () {
    Route::get('', 'ScheduleController@index');
    Route::get('getUserSchedule/{user}', 'ScheduleController@getUserSchedule');
    Route::post('', 'ScheduleController@store');
    Route::patch('{user}', 'ScheduleController@update');
});

Route::prefix('Salary')->group(function () {
    Route::get('', 'SalaryController@index');
    Route::post('', 'SalaryController@store');
    Route::patch('{salary}', 'SalaryController@update');
});

Route::prefix('DTR')->group(function () {
    Route::get('', 'DailyTimeRecordController@index');
    Route::prefix('{employee}')->group(function () {
        Route::get('', 'DailyTimeRecordController@show')->middleware('can:view,employee');
        Route::patch('', 'DailyTimeRecordController@update');
    });
    Route::get('{date}/Employee/{employee}/Process', 'DailyTimeRecordController@process');
});

Route::prefix('Shift')->group(function () {
    Route::get('', 'ShiftController@index');
    Route::get('list', 'ShiftController@list');
    Route::post('', 'ShiftController@store');

    Route::patch('{shift}', 'ShiftController@update');

    Route::delete('{shift}', 'ShiftController@delete');
});

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

Route::prefix('Overtime')->group(function () {
    Route::get('', 'OvertimeController@index');
    Route::post('', 'OvertimeController@store');

    Route::get('{employee}', 'OvertimeController@show')->middleware('can:view,employee');
    
    Route::prefix('{overtime}')->group(function () {
        Route::patch('', 'OvertimeController@update');
        Route::patch('status', 'OvertimeController@update_status');
    });
});

Route::prefix('Override')->group(function () {
    Route::get('', 'OverrideController@index');
    Route::post('', 'OverrideController@store');

    Route::get('{employee}', 'OverrideController@show')->middleware('can:view,employee');

    Route::prefix('{override}')->group(function () {
        Route::patch('', 'OverrideController@update');
        Route::patch('status', 'OverrideController@update_status');
    });
});

Route::prefix('Holiday')->group(function () {
    Route::get('', 'HolidayController@index');
    Route::post('', 'HolidayController@store');

    Route::prefix('{holiday}')->group(function () {
        Route::patch('', 'HolidayController@update');
        Route::delete('', 'HolidayController@destroy');
    });
});

Route::get('Calendar', 'CalendarController@index');

Route::get('/Patients', 'Patient\PatientController@index');
Route::get('/getPatientsAtDate', 'Patient\PatientRecordController@getPatientsAtDate');
Route::prefix('Patient')->group(function () {
    Route::post('', 'Patient\PatientController@store');
    Route::post('CreateFromDashboard', 'Patient\PatientController@createFromDashboard');
    Route::get('Export/{ids}', 'Patient\PatientController@export');
    Route::post('Import', 'Patient\PatientController@import');
    Route::get('Create', 'Patient\PatientController@create');
    
    Route::prefix('{patient}')->group(function () {
        Route::get('Edit', 'Patient\PatientController@edit');
        Route::patch('', 'Patient\PatientController@update');
    
        Route::post('HFD', 'Patient\PatientHeridoFamilialDiseaseController@store');
        Route::patch('HFD/{desease}', 'Patient\PatientHeridoFamilialDiseaseController@update');
        
        Route::post('Allergy', 'Patient\PatientAllergyController@store');
        Route::patch('Allergy/{allergy}', 'Patient\PatientAllergyController@update');

        Route::prefix('Record')->group(function () {
            Route::get('Create', 'Patient\PatientRecordController@create');
            Route::post('', 'Patient\PatientRecordController@storeFromDashboard');
            Route::post('Tab/{tab}', 'Patient\PatientRecordController@store');

            Route::prefix('{record}')->group(function () {
                Route::get('', 'Patient\PatientRecordController@index');
                
                Route::get('Edit', 'Patient\PatientRecordController@edit');
                
                Route::patch('Tab/{tab}', 'Patient\PatientRecordController@update');
                
                Route::post('Medication', 'Patient\PatientRecordMedicationController@store');
                Route::patch('Medication/{medication}', 'Patient\PatientRecordMedicationController@update');
                
                Route::post('Hospitalization', 'Patient\PatientHospitalizationController@store');
                Route::patch('Hospitalization/{hospitalization}', 'Patient\PatientHospitalizationController@update');
                
                Route::post('PastMedication', 'Patient\PatientPastMedicationController@store');
                Route::patch('PastMedication/{pastmed}', 'Patient\PatientPastMedicationController@update');
                
                Route::post('Request', 'Patient\PatientRecordRequestController@store');
                Route::delete('Request/{record_request}', 'Patient\PatientRecordRequestController@delete');

                Route::post('Diagnosis', 'Patient\PatientRecordDiagnosisController@store');
                Route::delete('Diagnosis/{diagnonsis}', 'Patient\PatientRecordDiagnosisController@delete');
            });
        });
    });
});

Route::prefix('Payroll')->group(function () {
    Route::get('Computation', 'Payroll\ComputationController@index');
    Route::get('Process', 'Payroll\ComputationController@process');
    Route::get('PaySlip', 'Payroll\PayslipController@index');
    
    
    Route::get('Settings', 'Payroll\SettingController@index');
    Route::patch('Settings', 'Payroll\SettingController@update');

});

Route::prefix('Lookup')->group(function () {
    Route::get('', 'LookupController@index');
    Route::post('', 'LookupController@store')->name('lookup.store');
    
    Route::get('/lookups', 'LookupController@lookups');
    Route::get('/prettylookups', 'LookupController@getPrettyLookups');
    
    Route::prefix('{lookup}')->group(function () {
        Route::put('', 'LookupController@update')->name('lookup.update');
        Route::delete('', 'LookupController@destroy')->name('lookup.destroy');
    });
});

Route::get('/Notifications', function () {
    $notifBell = auth()->user()->unreadNotifications()->orderBy('updated_at')->get();
    return response($notifBell);
});

Route::patch('/Notifications/{notification}', function ($notification) {
    auth()->user()->unreadNotifications()->find($notification)->markAsRead();
});