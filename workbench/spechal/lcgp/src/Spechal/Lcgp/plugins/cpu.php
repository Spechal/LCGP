<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');

    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'cpu';

    $obj = new CollectdGraphStacked($config);

    $obj->setOrder(array('idle', 'nice', 'user', 'wait', 'system', 'softirq', 'interrupt', 'steal'));
    $obj->setDataSourceNames(array(
            'idle' => 'Idle',
            'nice' => 'Nice',
            'user' => 'User',
            'wait' => 'I/O Wait',
            'system' => 'System',
            'softirq' => 'SoftIRQ',
            'interrupt' => 'Interrupt',
            'steal' => 'Steal',
        )
    );

    $obj->setColors(array(
        'idle' => 'E8E8E8',
        'nice' => '00E000',
        'user' => '0000FF',
        'wait' => 'FFB000',
        'system' => 'FF0000',
        'softirq' => 'FF00FF',
        'interrupt' => 'A000A0',
        'steal' => '000000'
    ));

    $obj->setTitle('CPU-'.$obj->getArg('plugin_instance').' Usage');
    $obj->setVertical('Jiffies');
    $obj->setFormat('%5.2lf');
    $obj->addRRDOption('-u 100');
    $obj->setScale(0);

    $graphs[$config['plugin']][] = $obj->rrd_graph();