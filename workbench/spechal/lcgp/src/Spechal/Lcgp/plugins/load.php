<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'load';

    $obj = new CollectdGraphDefault($config);
    $obj->setDataSources(array('shortterm', 'midterm', 'longterm'));
    $obj->setDataSourceNames(array(
        'shortterm' => '1 min',
        'midterm' => '5 min',
        'longterm' => '15 min',
        )
    );

    $obj->setColors(array('shortterm' => '00FF00', 'midterm' => '0000FF', 'longterm' => 'FF0000'));

    $obj->setTitle('Load')->setVertical('System Load')->setFormat('%.2lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();
