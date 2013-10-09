<?php

    Route::get('/collectd/plugins/{host}', 'IndexController@getHostPlugins');

    Route::get('/graph/{host}/{plugin}', 'IndexController@graph');

    Route::get('/rrd/file/{file}', 'IndexController@rrd');

    Route::get('/', 'IndexController@getIndex');