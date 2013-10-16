<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');

    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'entropy';

    $obj = new CollectdGraphDefault($config);

    $obj->setDataSources(array('value'));
    $obj->setDataSourceNames(array(
            'value' => 'Entropy Bits'
        )
    );

    $obj->setColors(array(
        'value' => '000F00'
    ));

    $obj->setTitle('Available Entropy');
    $obj->setVertical('Bits');
    $obj->setFormat('%4.0lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();