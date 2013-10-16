<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'mysql';

    $obj = new CollectdGraphStacked($config);
    $obj->setFormat('%5.1lf%s');
    #$obj->setDataSources(array('read', 'write'));

    switch($obj->getArg('type')){
        case 'cache_result':
            $obj->setDataSourceNames(array(
                    'qcache-not_cached' => 'Not Cached',
                    'qcache-inserts' => 'Inserts',
                    'qcache-hits' => 'Hits',
                    'qcache-prunes' => 'Low Memory Prunes'
                )
            );
            $obj->setColors(
                array(
                    'qcache-not_cached' => 'F0A000',
                    'qcache-inserts' => '0000FF',
                    'qcache-hits' => '00E000',
                    'qcache-prunes' => 'FF0000'
                )
            );
            $obj->setTitle('Query Cache ('.$obj->getArg('plugin_instance').')')->setVertical('Queries per second');
            break;
        case 'cache_size':
            $obj->setDataSourceNames(array(
                    'qcache' => 'Queries'
                )
            );
            $obj->setTitle('Query Cache Size ('.$obj->getArg('plugin_instance').')')->setVertical('Queries in cache');
            break;
        case 'mysql_commands':
            $obj->setTitle('Commands ('.$obj->getArg('plugin_instance').')')->setVertical('Issues per second');
            break;
        case 'mysql_handler':
            $obj->setOrder(
                array(
                    'commit',
                    'delete',
                    'read_first',
                    'read_key',
                    'read_next',
                    'read_prev',
                    'read_rnd',
                    'read_rnd_next',
                    'update',
                    'write',
                    'rollback'
                )
            );
            $obj->setColors(
                array(
                    'commit' => 'FF0000',
                    'delete' => 'FF00E7',
                    'read_first' => 'CC00FF',
                    'read_key' => '3200FF',
                    'read_next' => '0065FF',
                    'read_prev' => '00FFF3',
                    'read_rnd' => '00FF65',
                    'read_rnd_next' => '33FF00',
                    'update' => 'CBFF00',
                    'write' => 'FF9800',
                    'rollback' => '000000',
                )
            );
            $obj->setTitle('MySQL Handler ('.$obj->getArg('plugin_instance').')')->setVertical('Invocations');
            break;
        case 'mysql_locks':
            $obj->setColors(
                array(
                    'immediate' => 'FF0000',
                    'waited' => '00FF00'
                )
            );
            $obj->setTitle('MySQL Locks ('.$obj->getArg('plugin_instance').')')->setVertical('Locks');
            break;
        case 'mysql_octets':
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
            $obj->setTitle('MySQL Traffic ('.$obj->getArg('plugin_instance').')')->setVertical('Bits per second');
            break;
        case 'threads':
            $obj->setDataSourceNames(array(
                    'cached' => 'Cached',
                    'connected' => 'Connected',
                    'running' => 'Running'
                )
            );
            $obj->setColors(
                array(
                    'cached' => '00E000',
                    'connected' => '0000FF',
                    'running' => 'FF0000'
                )
            );
            $obj->setTitle('MySQL Threads ('.$obj->getArg('plugin_instance').')')->setVertical('Threads');
            break;
        case 'total_threads':
            $obj->setDataSourceNames(array(
                    'created' => 'Created'
                )
            );
            $obj->setTitle('MySQL Created Threads ('.$obj->getArg('plugin_instance').')')->setVertical('Created Threads');
            break;
        default:
            break;
    }

    $graphs[$config['plugin']][] = $obj->rrd_graph();
