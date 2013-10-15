<?php

namespace Spechal\Lcgp;

use Whoops\Example\Exception;

class Collectd {

    protected $_rrd_dir = NULL;

    public function __construct($rrd_dir){
        $this->_rrd_dir = $rrd_dir;
    }

    /**
     * Get a list of hosts based on directory names
     *
     * @return array
     * @throws \Whoops\Example\Exception
     */
    public function hosts(){
        if(!is_dir($this->_rrd_dir))
            throw new Exception('Invalid RRD directory.');

        $dirs = array_diff(scandir($this->_rrd_dir), array('.', '..'));

        foreach($dirs as $key => $dir)
            if(!is_dir($this->_rrd_dir . DIRECTORY_SEPARATOR . $dir))
                unset($dirs[$key]);

        return $dirs;
    }

    /**
     * Get a list of plugins from a host
     *
     * @param $host
     * @return array
     */
    public function plugins($host){
        $data = new CollectdPlugin($this->_rrd_dir, $host);
        $data = $data->data();
        $plugins = array();
        foreach($data as $plugin)
            if(!in_array($plugin['plugin'], $plugins))
                $plugins[] = $plugin['plugin'];

        return $plugins;
    }

    public function groupPlugins($plugin_data){
        $data = array();
        foreach($plugin_data as $plugin){
            if(!preg_match('#^(df|interface)$#', $plugin['plugin']))
                if($plugin['plugin'] != 'libvirt' && ($plugin['plugin'] != 'snmp' && $plugin['type'] != 'if_octets'))
                    unset($plugin['type_instance']);
            $data[] = $plugin;
        }

        $data = array_map("unserialize", array_unique(array_map("serialize", $data)));
        return $data;
    }

    public function sortPlugins($plugin_data){
        if (empty($plugin_data))
            return $plugin_data;

        foreach ($plugin_data as $key => $row) {
            $pi[$key] = (isset($row['plugin_instance'])) ? $row['plugin_instance'] : null;
            $c[$key]  = (isset($row['category']))  ? $row['category'] : null;
            $ti[$key] = (isset($row['type_instance'])) ? $row['type_instance'] : null;
            $t[$key]  = (isset($row['type']))  ? $row['type'] : null;
        }

        array_multisort($c, SORT_ASC, $pi, SORT_ASC, $t, SORT_ASC, $ti, SORT_ASC, $plugin_data);

        return $plugin_data;
    }

    public function pluginData($host, $plugin){
        $data = new CollectdPlugin($this->_rrd_dir, $host);
        $data = $data->data($plugin);
        return $data;
    }

    public function pluginDetail($host, $plugin, $detail){
        $data = new CollectdPlugin($this->_rrd_dir, $host);
        $data = $data->details($plugin, $detail);
        return $data;
    }

}