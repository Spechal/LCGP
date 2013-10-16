<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'processes';

    $obj = new CollectdGraphStacked($config);

    switch($obj->getArg('type')){
        case 'ps_state':
            $obj->setDataSourceNames(
                array(
                    'paging' => 'Paging',
                    'blocked' => 'Blocked',
                    'zombies' => 'Zombies',
                    'stopped' => 'Stopped',
                    'running' => 'Running',
                    'sleeping' => 'Sleeping'
                )
            );
            $obj->setColors(
                array(
                    'paging' => 'FFB000',
                    'blocked' => 'FF00FF',
                    'zombies' => 'FF0000',
                    'stopped' => 'A000A0',
                    'running' => '00E000',
                    'sleeping' => 'F0A000'
                )
            );
            $obj->setTitle('Processes')->setVertical('Processes');
            break;
        case 'fork_rate':
            $obj->setDataSourceNames(
                array(
                    'value' => 'Forks'
                )
            );
            $obj->setColors(
                array(
                    'value' => 'F0A000'
                )
            );
            $obj->setTitle('Fork Rate')->setVertical('Forks per second');
            break;
        case 'ps_code':
            $obj->setDataSourceNames(
                array(
                    'value' => 'TRS'
                )
            );
            $obj->setColors(
                array(
                    'value' => '0000FF'
                )
            );
            $obj->setTitle('Text Resident Set ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes');
            break;
        case 'ps_count':
            $obj->setDataSources(array('processes', 'threads'));
            $obj->setDataSourceNames(
                array(
                    'processes' => 'Processes',
                    'threads' => 'Threads'
                )
            );
            $obj->setColors(
                array(
                    'processes' => '0000FF',
                    'threads' => 'FF0000'
                )
            );
            $obj->setTitle('Processes / Threads ('.$obj->getArg('plugin_instance').')')->setVertical('Amount');
            break;
        case 'ps_cputime':
            $obj->setDataSources(array('processes', 'threads'));
            $obj->setDataSourceNames(
                array(
                    'user' => 'User',
                    'syst' => 'System'
                )
            );
            $obj->setColors(
                array(
                    'user' => '0000FF',
                    'syst' => 'FF0000'
                )
            );
            $obj->setTitle('CPU Time ('.$obj->getArg('plugin_instance').')')->setVertical('CPU Time [s]');
            break;
        case 'ps_disk_octets':
            $obj->setDataSources(array('read', 'write'));
            $obj->setDataSourceNames(
                array(
                    'read' => 'Read',
                    'write' => 'Write'
                )
            );
            $obj->setColors(
                array(
                    'read' => '0000FF',
                    'write' => '00B000'
                )
            );
            $obj->setTitle('Disk Traffic ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes per second');
            break;
        case 'ps_disk_ops':
            $obj->setDataSources(array('read', 'write'));
            $obj->setDataSourceNames(
                array(
                    'read' => 'Read',
                    'write' => 'Write'
                )
            );
            $obj->setColors(
                array(
                    'read' => '0000FF',
                    'write' => '00B000'
                )
            );
            $obj->setTitle('Disk Operations ('.$obj->getArg('plugin_instance').')')->setVertical('Ops per second');
            break;
        case 'ps_data':
            $obj->setDataSourceNames(
                array(
                    'value' => 'DRS'
                )
            );
            $obj->setColors(
                array(
                    'value' => '0000FF'
                )
            );
            $obj->setTitle('Data Resident Set ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes');
            break;
        case 'ps_pagefaults':
            $obj->setDataSources(array('minflt', 'majflt'));
            $obj->setDataSourceNames(
                array(
                    'minflt' => 'Minor',
                    'majflt' => 'Major'
                )
            );
            $obj->setColors(
                array(
                    'minflt' => '0000FF',
                    'majflt' => '0000FF'
                )
            );
            $obj->setTitle('Page Faults ('.$obj->getArg('plugin_instance').')')->setVertical('Page Faults');
            break;
        case 'ps_rss':
            $obj->setDataSourceNames(
                array(
                    'value' => 'RSS'
                )
            );
            $obj->setColors(
                array(
                    'value' => '0000FF'
                )
            );
            $obj->setTitle('Resident Segment Size ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes');
            break;
        case 'ps_stacksize':
            $obj->setDataSourceNames(
                array(
                    'value' => 'Stack Size'
                )
            );
            $obj->setColors(
                array(
                    'value' => '0000FF'
                )
            );
            $obj->setTitle('Stack Size ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes');
            break;
        case 'ps_vm':
            $obj->setDataSourceNames(
                array(
                    'value' => 'Memory'
                )
            );
            $obj->setColors(
                array(
                    'value' => '0000FF'
                )
            );
            $obj->setTitle('Virtual Memory ('.$obj->getArg('plugin_instance').')')->setVertical('Bytes');
            break;
        default:
            break;
    }

    $obj->setFormat('%5.1lf%s');
    $graphs[$config['plugin']][] = $obj->rrd_graph();
