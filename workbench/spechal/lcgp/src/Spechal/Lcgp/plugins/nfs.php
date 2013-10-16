<?php

    namespace Spechal\Lcgp;

    $config = \Config::get('lcgp::collectd');
    // host comes from the controller that load the plugin
    $config['host'] = $host;
    $config['plugin'] = 'nfs';

    $obj = new CollectdGraphStacked($config);
    $obj->setDataSources(array('value'));

    switch($obj->getArg('type')){
        case 'v2client':
            $this->setOrder(
                array(
                    'create',
                    'fsstat',
                    'getattr',
                    'link',
                    'lookup',
                    'mkdir',
                    'null',
                    'readdir',
                    'readlink',
                    'read',
                    'remove',
                    'rename',
                    'rmdir',
                    'root',
                    'setattr',
                    'symlink',
                    'wrcache',
                    'write'
                )
            );
            break;
        case 'v3client':
            $this->setOrder(
                array(
                    'access',
                    'commit',
                    'create',
                    'fsinfo',
                    'fsstat',
                    'getattr',
                    'link',
                    'lookup',
                    'mkdir',
                    'mknod',
                    'null',
                    'pathconf',
                    'read',
                    'readdir',
                    'readdirplus',
                    'readlink',
                    'remove',
                    'rename',
                    'rmdir',
                    'setattr',
                    'symlink',
                    'write'
                )
            );
            break;
        default:
            break;
    }

    $obj->setTitle('NFS Operations ('.$obj->getArg('plugin_instance').')')->setVertical('Operations')->setFormat('%5.2lf');

    $graphs[$config['plugin']][] = $obj->rrd_graph();
