<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'memcached';

    switch($_GET['type']){
        case 'df':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('used', 'free'));
            $obj->setDataSourceNames(array('used' => 'Used', 'free' => 'Free'));
            $obj->setOrder(array('used', 'free'));
            $obj->setColors(array('used' => '00E000', 'free' => '0000FF'));
            $obj->setTitle('Memory Usage')->setVertical('Bytes');
            break;
        case 'memcached_command':
            $obj = new CollectdGraphStacked($config);
            $obj->setDataSourceNames(array('flush' => 'Flush', 'get' => 'Get', 'set' => 'Set'));
            $obj->setOrder(array('flush', 'get', 'set'));
            $obj->setColors(array('flush' => '00E000', 'get' => '0000FF', 'set' => 'FFB000'));
            $obj->setTitle('Commands')->setVertical('Commands');
            break;
        case 'memcached_connections':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('value'));
            $obj->setDataSourceNames(array('value' => 'Connections'));
            $obj->setColors(array('value' => '00B000'));
            $obj->setTitle('Number of connections')->setVertical('Connections');
            break;
        case 'memcached_items':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('value'));
            $obj->setDataSourceNames(array('value' => 'Items'));
            $obj->setColors(array('value' => '00B000'));
            $obj->setTitle('Items in cache')->setVertical('Items');
            break;
        case 'memcached_octets':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('rx', 'tx'));
            $obj->setDataSourceNames(array(
                    'rx' => 'Receive',
                    'tx' => 'Transmit'
                )
            );
            $obj->setColors(
                array(
                    'rx' => '0000FF',
                    'tx' => '00B000'
                )
            );
            $obj->setTitle('Network Traffic ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes per second');
            break;
        case 'memcached_ops':
            $obj = new CollectdGraphStacked($config);
            $obj->setDataSourceNames(array('evictions' => 'Evictions', 'hits' => 'Hits', 'misses' => 'Misses'));
            $obj->setOrder(array('evictions', 'hits', 'misses'));
            $obj->setColors(array('evictions' => '00E000', 'hits' => '0000FF', 'misses' => 'FFB000'));
            $obj->setTitle('Operations')->setVertical('Commands');
            break;
        case 'percent':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('value'));
            $obj->setDataSourceNames(array('value' => 'Percent'));
            $obj->setColors(array('value' => '00B000'));
            $obj->setTitle('Hit/Miss Ratio')->setVertical('Percent');
            break;
        case 'ps_count':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('threads'));
            $obj->setDataSourceNames(array('threads' => 'Threads'));
            $obj->setColors(array('threads' => '00B000'));
            $obj->setTitle('Thread Count')->setVertical('Number of threads');
            break;
        case 'ps_cputime':
            $obj = new CollectdGraphDefault($config);
            $obj->setDataSources(array('user', 'syst'));
            $obj->setDataSourceNames(array('user' => 'User', 'syst' => 'System'));
            $obj->setOrder(array('user', 'syst'));
            $obj->setColors(array('user' => '00E000', 'syst' => '0000FF'));
            $obj->setTitle('CPU Time')->setVertical('Time');
            break;
        default:
            break;
    }

    $obj->setFormat("%5.1lf");

    $graphs[$config['plugin']][] = $obj->rrd_graph();
