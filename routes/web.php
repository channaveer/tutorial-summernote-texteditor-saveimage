<?php

Route::get('/', 'FileUploadsController@create');
Route::post('/file-uploads', 'FileUploadsController@store');
