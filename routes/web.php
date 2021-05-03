<?php

use App\Providers\RouteServiceProvider;

Auth::routes();

Route::get('/{any}', 'AppController@index')->where('any', '.*');