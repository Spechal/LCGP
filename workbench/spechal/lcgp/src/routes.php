<?php

    Route::get('/collectd/plugins/{host}', 'Spechal\Lcgp\CollectdController@getHostPlugins');
    Route::post('/collectd/plugins/{host}', 'Spechal\Lcgp\CollectdController@getHostPlugins');

    Route::get('/collectd/graph/{host}/{plugin}', 'Spechal\Lcgp\CollectdController@graph');
    Route::post('/collectd/graph/{host}/{plugin}', 'Spechal\Lcgp\CollectdController@graph');

    Route::get('/collectd/rrd/file/{file}', 'Spechal\Lcgp\CollectdController@rrd');

    Route::get('/collectd/png/{host}/{plugin}', 'Spechal\Lcgp\CollectdController@png');