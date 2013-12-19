<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'memcached';

    switch($_GET['type']){
        case 'memory':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('used'));
            $obj->setDataSourceNames(array('used' => 'Used'));
            $obj->setOrder(array('used'));
            $obj->setColors(array('used' => '00E000'));
            $obj->setTitle('Memory Usage')->setVertical('Bytes');
            break;
        case 'current_connections':
            $obj = new CollectdGraphStacked($config);
            $obj->setDataSourceNames(array('clients' => 'Clients', 'slaves' => 'Slaves'));
            $obj->setOrder(array('clients', 'slaves'));
            $obj->setColors(array('clients' => '00E000', 'slaves' => '0000FF'));
            $obj->setTitle('Connections')->setVertical('Connections');
            break;
        case 'memcached_connections':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('value'));
            $obj->setDataSourceNames(array('value' => 'Connections'));
            $obj->setColors(array('value' => '00B000'));
            $obj->setTitle('Number of connections')->setVertical('Connections');
            break;
        default:
            break;
    }

    $obj->setFormat("%5.1lf");

    $graphs[$config['plugin']][] = $obj->rrd_graph();
