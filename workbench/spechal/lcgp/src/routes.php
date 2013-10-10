<?php

    Route::get('/collectd/plugins/{host}', 'Spechal\Lcgp\CollectdController@getHostPlugins');

    Route::get('/graph/{host}/{plugin}', 'Spechal\Lcgp\CollectdController@graph');

    Route::get('/rrd/file/{file}', 'Spechal\Lcgp\CollectdController@rrd');