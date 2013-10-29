<?php

    return array(
        'collectd' => array(
            'datadir' => '/opt/collectd/var/lib/collectd/rrd_tmpfs/',
            'rrdtool' => '/usr/bin/rrdtool',
            'rrdtool_opts' => array(),
            'cache' => 90, // seconds
            'width' => 400, // pixels
            'height' => 175, // pixels
            'detail-width' => 800, // pixels
            'detail-height' => 350, // pixels
            'graph_smooth' => FALSE,
            'negative_io' => FALSE,
            'graph_type' => 'canvas',
            'png' => FALSE // this doesn't work when set to TRUE until PNG support is fully implemented
        )
    );
