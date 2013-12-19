<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'redis';

    switch($_GET['type']){
        case 'memory':
            $obj = new CollectdGraphDefault($config);
            $obj->setTitle('Memory Usage')->setVertical('Bytes');
            break;
        case 'current_connections':
            $obj = new CollectdGraphStacked($config);
            $obj->setDataSourceNames(array('clients' => 'Clients', 'slaves' => 'Slaves'));
            $obj->setOrder(array('clients', 'slaves'));
            $obj->setColors(array('clients' => '00E000', 'slaves' => '0000FF'));
            $obj->setTitle('Connections')->setVertical('Connections');
            break;
        case 'total_connections':
            $obj = new CollectdGraphDefault($config);
            $obj->setTitle('Total Connections')->setVertical('Total Connections');
            break;
        case 'volatile_changes':
            $obj = new CollectdGraphDefault($config);
            $obj->setTitle('Volatile Changes')->setVertical('Volatile Changes');
            break;
        case 'total_operations':
            $obj = new CollectdGraphDefault($config);
            $obj->setTitle('Total Operations')->setVertical('Total Operations');
            break;
        default:
            break;
    }

    $obj->setFormat("%5.1lf");

    $graphs[$config['plugin']][] = $obj->rrd_graph();
