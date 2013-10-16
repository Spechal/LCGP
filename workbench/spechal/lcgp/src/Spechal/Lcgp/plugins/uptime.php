<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'uptime';

    $obj = new CollectdGraphUptime($config);
    $obj->setDataSources(array('value'));
    $obj->setDataSourceNames(array(
        'value' => 'Current'
        )
    );

    $obj->setColors(array('value' => '00E000'));

    $obj->setTitle('Uptime')->setVertical('Days')->setFormat('%.1lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();