<?php

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