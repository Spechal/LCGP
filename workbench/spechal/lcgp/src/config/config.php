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
            'png' => TRUE // this doesn't work when set to TRUE until PNG support is fully implemented
        ),
        'host_groups' => array(
            'PISCES' => array(
                // production
                'piscesweb10',
                'piscesweb11',
                'piscesweb12',
                'piscesweb13',
                'piscesweb14',
                'piscesweb15',
                'piscesweb16',
                'piscesweb17',
                'piscesweb18',
                'piscesweb19',
                'piscesweb20',
                'pisceswebnas',
                'piscesmariadb01',
                'piscesmariadb02',
                'piscesmariadb03',
                'piscesmariadb04',
                'pisces-varnish-prod1',
                'pisces-varnish-prod2',
                'pisces-varnish-prod3',
                'pisces-memcached-prod',
                'pisces-memcached-prod2',
                'pisces-memcached-prod3',
                // staging
            ),
            'KRANG' => array(
                'krang-be1',
                'krang-be3',
                'krang-web1',
                'krang-web2',
                'krang-web3',
                'krang-pbnas4',
                'krang-mysql-master',
                'krang-mysql-slave',
                'krang-texis-master',
                'krang-texis-query'
            ),
            'SOLR' => array(
                'solr-search1-prod',
                'solr-search2-prod',
                'solr-indexer-prod'
            ),
            'VBB-WP' => array(
                'vbbwpweb01.pme.penton.com',
                'vbbwpweb02.pme.penton.com',
                'vbbwpweb03.pme.penton.com',
                'vbbwpvarnish01.pme.penton.com',
                'vbbwpvarnish02.pme.penton.com',
                'neomysql01-wp-vbb',
                'neomysql02-wp-vbb',
                // old but current boxes
                'neoweb01-wp-vbb',
                'neoweb02-wp-vbb',
                'neoweb03-wp-vbb'
            )
        )
    );
