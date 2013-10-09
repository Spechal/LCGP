<?php

namespace Spechal\Lcgp;

use Whoops\Example\Exception;

class CollectdPlugin {

    protected $_rrd_dir = NULL;
    protected $_host = NULL;

    public function __construct($rrd_dir, $host){
        $this->_rrd_dir = $rrd_dir;
        if(!is_dir($this->_rrd_dir))
            throw new Exception('Invalid RRD directory.');
        $this->_host = $host;
        if(!is_dir($this->_rrd_dir . DIRECTORY_SEPARATOR . $this->_host))
            throw new Exception('Invalid host supplied.');
    }

    /**
     * Get plugin information
     *
     * If a plugin name is passed, only data pertaining to the plugin will be returned
     *
     * @param null $single_plugin
     * @return array
     */
    public function data($single_plugin = NULL){
        chdir($this->_rrd_dir . DIRECTORY_SEPARATOR . $this->_host);
        $files = glob('*/*.rrd');
        $data = array();

        if(empty($files))
            return $data;

        foreach($files as $key => $file){
            preg_match('`
                (?P<p>[\w_]+)      # plugin
                (?:(?<=varnish)(?:\-(?P<c>[\w]+)))? # category
                (?:\-(?P<pi>.+))?  # plugin instance
                /
                (?P<t>[\w_]+)      # type
                (?:\-(?P<ti>.+))?  # type instance
                \.rrd
            `x', $file, $matches);

            $data[] = array(
                'plugin' => $matches['p'],
                'category' => isset($matches['c']) ? $matches['c'] : '',
                'plugin_instance' => isset($matches['pi']) ? $matches['pi'] : '',
                'type' => $matches['t'],
                'type_instance' => isset($matches['ti']) ? $matches['ti'] : ''
            );
        }

        // only return data about one plugin
        if($single_plugin){
            $new_data = array();
            foreach($data as $tmp)
                if($tmp['plugin'] == $single_plugin)
                    $new_data[] = $tmp;

            $data = $new_data;
        }

        return $data;
    }

    /**
     * Not sure this is ever used ... found definition but no calls in CGP v4
     *
     * @param $plugin
     * @param $detail
     * @param null $where
     * @return array|bool
     */
    public function details($plugin, $detail, $where = NULL){
        $details = array('plugin_instance', 'category', 'type', 'type_instance');
        if(!in_array($detail, $details))
            return FALSE;

        $data = $this->data($plugin);
        $return = array();

        // not sure of the point behind the where since we already have one plugin
        if($where){
            $add = TRUE;
            foreach($where as $k => $v)
                if($data[$k] != $v)
                    $add = FALSE;

            if($add)
                $return[] = $data[$detail];
        } else {
            $return[] = $data[$detail];
        }
        return $return;
    }

}