<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'varnish';

    $obj = new CollectdGraphDefault($config);

    $obj->setTitle(ucfirst($obj->getArg('plugin_instance')))->setVertical('Hits')->setFormat('%5.1lf%s');

    $graphs[$config['plugin']][] = $obj->rrd_graph();
