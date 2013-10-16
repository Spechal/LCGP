<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');

    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'tcpconns';

    $obj = new CollectdGraphStacked($config);

    $obj->setTitle('TCP Connections ('.$obj->getArg('plugin_instance').')');
    $obj->setVertical('#');
    $obj->setFormat('%5.1lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();