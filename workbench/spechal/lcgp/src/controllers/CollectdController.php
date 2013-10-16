<?php

    namespace Spechal\Lcgp;

    class CollectdController extends \BaseController {

        public function getIndex(){
            $collectd = new Collectd('/opt/rrds');
            return \View::make('index.index')->with('hosts', $collectd->hosts());
        }

        public function getHostPlugins($host){
            $collectd = new Collectd('/opt/rrds');
            $plugins = $collectd->plugins($host);

            $graphs = array();
            foreach($plugins as $plugin){
                $data = $collectd->pluginData($host, $plugin);
                $data = $collectd->groupPlugins($data);
                $data = $collectd->sortPlugins($data);
                foreach($data as $d){
                    $plugin = $d['plugin'];
                    $_GET['category'] = (isset($d['category'])) ? $d['category'] : NULL;
                    $_GET['plugin_instance'] = (isset($d['plugin_instance'])) ? $d['plugin_instance'] : NULL;
                    $_GET['type'] = (isset($d['type'])) ? $d['type'] : NULL;
                    $_GET['type_instance'] = (isset($d['type_instance'])) ? $d['type_instance'] : NULL;

                    // this needs refactored ... can't have this hard set to a directory
                    include('/Users/travis.crowder/Dropbox/repos/git/LCGP/workbench/spechal/lcgp/src/Spechal/Lcgp/plugins/'.$plugin.'.php');
                }
            }

            return \View::make('index.plugins')->with(array('host' => $host, 'plugins' => $plugins, 'graphs' => $graphs));
        }

        public function graph($host, $plugin){
            $collectd = new Collectd('/opt/rrds');
            $plugins = $collectd->plugins($host);
            $data = $collectd->pluginData($host, $plugin);
            $data = $collectd->groupPlugins($data);
            $data = $collectd->sortPlugins($data);

            $graphs = array();
            foreach($data as $d){
                $plugin = $d['plugin'];
                $_GET['category'] = (isset($d['category'])) ? $d['category'] : NULL;
                $_GET['plugin_instance'] = (isset($d['plugin_instance'])) ? $d['plugin_instance'] : NULL;
                $_GET['type'] = (isset($d['type'])) ? $d['type'] : NULL;
                $_GET['type_instance'] = (isset($d['type_instance'])) ? $d['type_instance'] : NULL;

                // this needs refactored ... can't have this hard set to a directory
                include('/Users/travis.crowder/Dropbox/repos/git/LCGP/workbench/spechal/lcgp/src/Spechal/Lcgp/plugins/'.$plugin.'.php');
            }

            // $graph comes from the include
            return \View::make('index.graph')->with(array('host' => $host, 'plugins' => $plugins, 'plugin' => $plugin, 'graphs' => $graphs));
        }

        public function rrd($file){
            $config = \Config::get('lcgp::collectd');
            $path = $config['datadir'];
            $file = str_replace('|', '/', $file);
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            // fix this cache setting later
            //header("Expires: " .date(DATE_RFC822,strtotime($CONFIG['cache']." seconds")));
            if(ob_get_length())
                ob_clean();
            flush();
            readfile($path . DIRECTORY_SEPARATOR . $file);
            exit;
        }

        /**
         * PNG support is busted
         */
        public function png($host, $plugin){
            $collectd = new Collectd('/opt/rrds');
            $data = $collectd->pluginData($host, $plugin);
            $d = $data[0];
            #header("Expires: " . date(DATE_RFC822,strtotime($this->cache." seconds")));
            header("content-type: image/png");
            #$_GET['host'] = (isset($_GET['host'])) ? $_GET['host'] : NULL;
            #$_GET['plugin'] = (isset($_GET['plugin'])) ? $_GET['plugin'] : NULL;
            $plugin = $d['plugin'];
            $_GET['category'] = (isset($d['category'])) ? $d['category'] : NULL;
            $_GET['plugin_instance'] = (isset($d['plugin_instance'])) ? $d['plugin_instance'] : NULL;
            $_GET['type'] = (isset($d['type'])) ? $d['type'] : NULL;
            $_GET['type_instance'] = (isset($d['type_instance'])) ? $d['type_instance'] : NULL;

            // this needs refactored ... can't have this hard set to a directory
            #$host = $_GET['host'];
            #$plugin = $_GET['plugin'];
            include('/Users/travis.crowder/Dropbox/repos/git/LCGP/workbench/spechal/lcgp/src/Spechal/Lcgp/plugins/'.$plugin.'.php');

            $command = (string)$graphs[$plugin][0];

            echo `$command`;
        }

        public function missingMethod($params){
            echo '<pre>'; print_r($params); exit;
        }

    }