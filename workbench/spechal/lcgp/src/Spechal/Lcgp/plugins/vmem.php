<?php

        namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'vmem';

    $obj = new CollectdGraphStacked($config);

    switch($_GET['type']){
        case 'vmpage_faults':
            $obj->setDataSources(array('minflt', 'majflt'));
            $obj->setDataSourceNames(array(
                    'minflt' => 'Minor',
                    'mjrflt' => 'Major'
                )
            );
            $obj->setTitle('Page Faults')->setVertical('');
            break;
        case 'vmpage_io':
            $obj->setOrder(array('in', 'out'));
            $obj->setDataSourceNames(array(
                    'memory-in' => 'Memory (in)',
                    'memory-out' => 'Memory (out)',
                    'swap-in' => 'Swap (in)',
                    'swap-out' => 'Swap (out)',
                )
            );
            $obj->setTitle('Page I/O')->setVertical('');
            $obj->setColors(array('memory-in' => 'FF0000', 'memory-out' => '0000FF', 'swap-in' => 'FF00FF', 'swap-out' => 'FFFF00'));
            break;
        case 'vmpage_number':
            $obj->setDataSources(array('value'));
            $obj->setOrder(array(
                    'active_anon',
                    'active_file',
                    'anon_pages',
                    'bounce',
                    'dirty',
                    'file_pages',
                    'free_pages',
                    'inactive_anon',
                    'inactive_file',
                    'mapped',
                    'mlock',
                    'page_table_pages',
                    'slab_reclaimable',
                    'slab_unreclaimable',
                    'unevictable',
                    'unstable',
                    #'vmscan_write',
                    'writeback', '
                        writeback_temp'
                )
            );
            $obj->setTitle('Pages')->setVertical('');
            break;
        default:
            break;
    }

    $obj->setFormat('%5.1lf%s');
    $graphs[$config['plugin']][] = $obj->rrd_graph();