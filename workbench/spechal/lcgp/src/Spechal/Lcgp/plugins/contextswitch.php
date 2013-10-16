<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');

    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'contextswitch';

    $obj = new CollectdGraphDefault($config);

    $obj->setDataSources(array('value'));
    $obj->setDataSourceNames(array(
            'value' => 'Context Switches'
        )
    );

    $obj->setColors(array(
        'value' => '000F00'
    ));

    $obj->setTitle('Context Switches');
    $obj->setVertical('Switches per second');
    $obj->setFormat('%4.0lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();