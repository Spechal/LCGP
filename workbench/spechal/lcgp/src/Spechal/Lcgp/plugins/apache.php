<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'apache';

    $obj = new CollectdGraphDefault($config);
    $obj->setDataSources(array('value'));

    switch($_GET['type']){
        case 'apache_bytes':
            $obj->setDataSourceNames(array('value' => 'Bytes'));
            $obj->setTitle('Traffic')->setVertical('Bytes per second');
            $obj->setColors(array('value' => '0000FF'));
            break;
        case 'apache_connections':
            $obj->setDataSourceNames(array('value' => 'Connections per second'));
            $obj->setTitle('Connections')->setVertical('Connections per second');
            $obj->setColors(array('value' => '00B000'));
            break;
        case 'apache_idle_workers':
            $obj->setDataSourceNames(array('value' => 'Workers'));
            $obj->setTitle('Idle Workers')->setVertical('Workers');
            $obj->setColors(array('value' => '0000FF'));
            break;
        case 'apache_requests':
            $obj->setDataSourceNames(array('value' => 'Requests per second'));
            $obj->setTitle('Requests')->setVertical('Requests per second');
            $obj->setColors(array('value' => '00B000'));
            break;
        case 'apache_scoreboard':
            $obj = new CollectdGraphStacked($config);
            $obj->setOrder(
                array(
                    'open',
                    'idle_cleanup',
                    'finishing',
                    'logging',
                    'closing',
                    'dnslookup',
                    'keepalive',
                    'sending',
                    'reading',
                    'starting',
                    'waiting',
                    'connect',
                    'hard_error',
                    'close',
                    'response_end',
                    'write',
                    'response_start',
                    'handle_request',
                    'read_post',
                    'request_end',
                    'read',
                    'request_start',
                )
            );
            $obj->setDataSources(array('value'));
            $obj->setDataSourceNames(
                    array(
                        'open' => 'Open',
                        'waiting' => 'Waiting',
                        'starting' => 'Starting',
                        'reading' => 'Reading',
                        'sending' => 'Sending',
                        'keepalive' => 'KeepAlive',
                        'dnslookup' => 'DNS Lookup',
                        'closing' => 'Closing',
                        'logging' => 'Logging',
                        'finishing' => 'Fiinshing',
                        'idle_cleanup' => 'Idle Cleanup',
                        'connect' => 'Connect',
                        'close' => 'Close',
                        'hard_error' => 'Hard Error',
                        'read' => 'Read',
                        'read_post' => 'Read Post',
                        'write' => 'Write',
                        'handle_request' => 'Handle Request',
                        'request_start' => 'Request Start',
                        'request_end' => 'Request End',
                        'response_start' => 'Response Start',
                        'response_end' => 'Response End'
                    )
            );
            $obj->setTitle('Scoreboard')->setVertical('Slots');
            $obj->setColors(
                array(
                    'open'      => 'E0E0E0',
                    'waiting'   => 'FFB000',
                    'starting'  => 'FF00FF',
                    'reading'   => '0000FF',
                    'sending'   => '00E000',
                    'keepalive' => '0080FF',
                    'dnslookup' => 'FF0000',
                    'closing'   => '000080',
                    'logging'   => 'A000A0',
                    'finishing' => '008080',
                    'idle_cleanup' => 'FFFF00',
                    'connect'        => 'E0E0E0',
                    'close'          => '008080',
                    'hard_error'     => 'FF0000',
                    'read'           => 'FF00FF',
                    'read_post'      => '00E000',
                    'write'          => '000080',
                    'handle_request' => '0080FF',
                    'request_start'  => 'FFB000',
                    'request_end'    => '0000FF',
                    'response_start' => 'FFFF00',
                    'response_end'   => 'A000A0'
                )
            );
            break;
        default:
            break;
    }

    $obj->setFormat("%5.1lf");

    $graphs[$config['plugin']][] = $obj->rrd_graph();
