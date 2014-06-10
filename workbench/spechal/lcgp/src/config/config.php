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
                'piscesweb21',
                'piscesweb22',
                'pisceswebnas',
                'piscesmariadb01.pme.penton.com',
                'piscesmariadb02.pme.penton.com',
                'piscesmariadb03.pme.penton.com',
                'piscesmariadb04.pme.penton.com',
                'piscesmariadb05.pme.penton.com',
                'piscesmariadb06.pme.penton.com',
                'piscesmariadb07.pme.penton.com',
                'piscesmariadb08.pme.penton.com',
                'pisces-varnish-prod1',
                'pisces-varnish-prod2',
                'pisces-varnish-prod3',
                'piscesvarnishprod4.pme.penton.com',
                'piscesvarnishprod5.pme.penton.com',
                'pisces-memcached-prod',
                'pisces-memcached-prod2',
                'pisces-memcached-prod3',
                'piscesmemcachedprod4.pme.penton.com',
                'piscesmemcachedprod5.pme.penton.com',
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
                'krang-texis-query',
            ),
            'SOLR' => array(
                'solr-search1-prod',
                'solr-search2-prod',
                'solr-indexer-prod',
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
                'neoweb03-wp-vbb',
            ),
            'GlusterFS' => array(
                // production
                'glusterfs1.pme.penton.com',
                'glusterfs2.pme.penton.com',
                'glusterfs3.pme.penton.com',
                // staging
            ),
            'NEXT' => array(
                'nextacccache01.pme.penton.com',
                'nextacccache02.pme.penton.com',
                'nextaccdb01.pme.penton.com',
                'nextaccweb01.pme.penton.com',
                'nextaccweb02.pme.penton.com',
                'nextaccweb03.pme.penton.com',
                'nextaccweb04.pme.penton.com',
            ),
            'ENEWSPRO' => array(
                'enewspro-memcached1',
                'enewspro-memcached2',
                'enewspro-neomysql10',
                'enewspro-neomysql11',
                'enewspro-web1',
                'enewspro-web2'
            )
        )
    );
