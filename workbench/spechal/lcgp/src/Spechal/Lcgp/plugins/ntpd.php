<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'ntpd';

    $obj = new CollectdGraphDefault($config);
    $obj->setDataSourceNames(array(
            'ping' => 'Ping Time',
            'ping_stddev' => 'Ping Std. Deviation',
            'ping_droprate' => 'Ping Drop Rate'
        )
    );

    switch($_GET['type']){
        case 'delay':
            $obj->setTitle('Delay')->setVertical('Seconds');
            break;
        case 'frequency_offset':
            $obj->setTitle('Frequency Offset')->setVertical('ppm');
            break;
        case 'time_dispersion':
            $obj->setTitle('Time Dispersion')->setVertical('Seconds');
            break;
        case 'time_offset':
            $obj->setTitle('Time Offset')->setVertical('Seconds');
            break;
        default:
            break;
    }

    $obj->setFormat('%5.1lf%s');
    $graphs[$config['plugin']][] = $obj->rrd_graph();
