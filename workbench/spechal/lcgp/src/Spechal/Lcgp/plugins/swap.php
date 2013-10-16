<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'swap';

    switch($_GET['type']){
        case 'swap':
            $obj = new CollectdGraphStacked($config);
            $obj->setOrder(array('free', 'cached', 'used'));
            $obj->setDataSourceNames(array(
                    'free' => 'Free',
                    'cached' => 'Cached',
                    'used' => 'Used'
                )
            );
            $obj->setTitle('Swap Utilization')->setVertical('Bytes');
            $obj->setColors(array('free' => '00E000', 'cached' => '0000FF', 'used' => 'FF0000'));
            break;
        case 'swap_io':
            $obj = new CollectdGraphIO($config);
            $obj->setOrder(array('out', 'in'));
            $obj->setDataSourceNames(array(
                    'out' => 'Out',
                    'in' => 'In'
                )
            );
            $obj->setTitle('Swapped I/O Pages')->setVertical('Pages');
            $obj->setColors(array('out' => '0000FF', 'in' => '00B000'));
            break;
        default:
            break;
    }

    $obj->setFormat('%5.1lf%s');
    $graphs[$config['plugin']][] = $obj->rrd_graph();
