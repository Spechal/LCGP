<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'irq';

    $obj = new CollectdGraphStacked($config);

    $obj->setTitle('Interrupts')->setVertical('Requests per second')->setFormat('%6.1lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();
