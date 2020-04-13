<?php

/**
 * Laravel Email Template Routes
 */
Route::group(['namespace' => 'Alliance\LaravelEmailTemplate\Http\Controllers'], function () {
    Route::get('template', 'LaravelEmailTemplateController@index')->name('laravelemailtemplate.index');
    Route::post('template', 'LaravelEmailTemplateController@store')->name('laravelemailtemplate.store');
    Route::put('template/{template}', 'LaravelEmailTemplateController@update')->name('laravelemailtemplate.update');
    Route::delete('template/{template}', 'LaravelEmailTemplateController@destroy')->name('laravelemailtemplate.delete');
});