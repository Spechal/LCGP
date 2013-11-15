<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'interface';

    $obj = new CollectdGraphIO($config);
    $obj->setDataSources(array('rx', 'tx'));
    $obj->setDataSourceNames(array(
        'rx' => 'Receive',
        'tx' => 'Transmit'
        )
    );

    $obj->setColors(array('rx' => '0000FF', 'tx' => '00B000'));

    $obj->setFormat('%.0lf');

    switch($obj->getArg('type')){
        case 'if_errors':
            $obj->setTitle('Interface Errors ('.$obj->getArg('plugin_instance').')')->setVertical('Errors per second');
            break;
        case 'if_octets':
            $obj->setTitle('Interface Traffic ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes per second');
            break;
        case 'if_packets':
            $obj->setTitle('Interface Packets ('.$obj->getArg('plugin_instance').')')->setVertical('Packets per second');
            break;
        default:
            break;
    }

    $graphs[$config['plugin']][] = $obj->rrd_graph();
