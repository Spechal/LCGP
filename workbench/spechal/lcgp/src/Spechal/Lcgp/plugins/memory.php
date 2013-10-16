<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');

    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'memory';

    $obj = new CollectdGraphStacked($config);

    $obj->setOrder(array('free', 'buffered', 'cached', 'locked', 'used'));
    $obj->setDataSourceNames(array(
            'free' => 'Free',
            'buffered' => 'Buffered',
            'cached' => 'Cached',
            'locked' => 'Locked',
            'used' => 'Used'
        )
    );

    $obj->setColors(array(
        'free' => '00E000',
        'buffered' => '0000FF',
        'cached' => 'FFB000',
        'locked' => 'FF00FF',
        'used' => 'FF0000'
    ));

    $obj->setTitle('Physical Memory Usage');
    $obj->setVertical('Bytes');
    $obj->setFormat('%5.1lf%s');

    $graphs[$config['plugin']][] = $obj->rrd_graph();