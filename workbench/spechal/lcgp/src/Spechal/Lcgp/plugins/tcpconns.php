<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');

    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'tcpconns';

    $obj = new CollectdGraphStacked($config);

    $obj->setTitle('TCP Connections ('.$this->getArg('plugin_instance').')')->setVertical('#')->setFormat('%5.1lf');

    $graphs[] = $obj->rrd_graph();