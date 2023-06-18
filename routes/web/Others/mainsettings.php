<?php

Route::prefix('Settings')->group(function () {
    Route::get('', 'MainSettings\MainSettingsController@index');
    
    Route::prefix('User-Nav-Connections')->group(function () {
        Route::get('', 'MainSettings\Navigations\UserNavConnectionsController@index');
        Route::get('{navname}', 'MainSettings\Navigations\UserNavConnectionsController@main_nav');
        Route::get('{navname}/{subnavname}', 'MainSettings\Navigations\UserNavConnectionsController@subnavname');
    });

});
