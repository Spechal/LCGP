<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'users';

    $obj = new CollectdGraphDefault($config);
    $obj->setDataSourceNames(array(
        'value' => 'Users'
        )
    );

    $obj->setColors(array('value' => '0000F0'));

    $obj->setTitle('Users')->setVertical('Logged in')->setFormat('%.1lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();
