<?php

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