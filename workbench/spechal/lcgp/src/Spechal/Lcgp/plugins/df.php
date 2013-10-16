<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'df';

    $obj = new CollectdGraphStacked($config);
    $obj->setDataSources(array('value'));
    $obj->setOrder(array('reserved', 'free', 'used'));
    $obj->setDataSourceNames(
        array(
            'reserved' => 'Reserved',
            'free' => 'Free',
            'used' => 'Used'
        )
    );

    $obj->setColors(array('reserved' => 'AAAAAA', 'free' => '00FF00', 'used' => 'FF0000'));

    $obj->setTitle('Free space ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes')->setFormat('%5.1lf%sB');

    $graphs[$config['plugin']][] = $obj->rrd_graph();
