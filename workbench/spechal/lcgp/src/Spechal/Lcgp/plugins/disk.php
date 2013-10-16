<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'disk';

    $obj = new CollectdGraphIO($config);
    $obj->setDataSources(array('read', 'write'));
    $obj->setDataSourceNames(array(
        'read' => 'Read',
        'write' => 'Written'
        )
    );

    $obj->setColors(array('read' => '0000FF', 'write' => '00B000'));

    switch($obj->getArg('type')){
        case 'disk_merged':
            $obj->setTitle('Disk Merge Operations ('.$obj->getArg('plugin_instance').')')->setVertical('Merged Operations per second')->setFormat('%5.1lf%s');
            break;
        case 'disk_octets':
            $obj->setTitle('Disk Traffic ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes per second')->setFormat('%5.1lf%s');
            break;
        case 'disk_ops':
            $obj->setTitle('Disk Operations ('.$obj->getArg('plugin_instance').')')->setVertical('Operations per second')->setFormat('%5.1lf%s');
            break;
        case 'disk_time':
            $obj->setTitle('Disk Time per op ('.$obj->getArg('plugin_instance').')')->setVertical('Avg Time per op')->setFormat('%5.1lf%s')->setScale(0.001);
            break;
        default:
            break;
    }

    $graphs[$config['plugin']][] = $obj->rrd_graph();
