<?php

    namespace Spechal\Lcgp;

    class CollectdController extends \BaseController {

        public function getIndex(){
            $collectd = new Collectd(\Config::get('lcgp::collectd.datadir'));
            $names = $collectd->hosts();
            $host_groups = \Config::get('lcgp::host_groups');
            $groups = array(); // group array to display
            $hosts = array(); // hosts array to display
            foreach($names as $host){
                $hosts[$host] = array();
                $hosts[$host]['name'] = $host;
                $data = $collectd->readRRD(\Config::get('lcgp::collectd.datadir') . DIRECTORY_SEPARATOR . $host . DIRECTORY_SEPARATOR . 'load' . DIRECTORY_SEPARATOR . 'load.rrd');
                $hosts[$host]['cores'] = count($collectd->groupPlugins($collectd->pluginData($host, 'cpu')));
                $hosts[$host]['short'] = $data['ds[shortterm].last_ds'];
                $hosts[$host]['mid'] = $data['ds[midterm].last_ds'];
                $hosts[$host]['long'] = $data['ds[longterm].last_ds'];
                // groupings
                foreach($host_groups as $name => $group_members){
                    if(in_array($host, $group_members)){
                        $groups[$name][] = $hosts[$host];
                        unset($hosts[$host]);
                    }
                }
            }

            return \View::make('lcgp::index')->with(array('groups' => $groups, 'hosts' => $hosts));
        }

        public function getHostPlugins($host){
            $collectd = new Collectd(\Config::get('lcgp::collectd.datadir'));
            $plugins = $collectd->plugins($host);

            // convert POSTed start and end times to GETs
            if(isset($_POST['start']))
                $_GET['start'] = strtotime($_POST['start']);

            if(isset($_POST['end']))
                $_GET['end'] = strtotime($_POST['end']);

            $start = isset($_GET['start']) ? $_GET['start'] : NULL;
            $end = isset($_GET['end']) ? $_GET['end'] : NULL;

            $graphs = array();
            foreach($plugins as $plugin){
                $data = $collectd->pluginData($host, $plugin);
                $data = $collectd->groupPlugins($data);
                $data = $collectd->sortPlugins($data);
                foreach($data as $d){
                    $plugin = $d['plugin'];
                    $_GET['category'] = $cat = (isset($d['category'])) ? $d['category'] : NULL;
                    $_GET['plugin_instance'] = $plugin_instance = (isset($d['plugin_instance'])) ? $d['plugin_instance'] : NULL;
                    $_GET['type'] = $type = (isset($d['type'])) ? $d['type'] : NULL;
                    $_GET['type_instance'] = $type_instance = (isset($d['type_instance'])) ? $d['type_instance'] : NULL;

                    // if no PNG usage, get the canvas code ... otherwise use img tags
                    if(!\Config::get('lcgp::collectd.png'))
                        include(__DIR__.'/../Spechal/Lcgp/plugins/'.$plugin.'.php');
                    else
                        $graphs[$plugin][] = '<img src="/collectd/png/'.$host.'/'.$plugin.'?plugin_instance='.$plugin_instance.'&type='.$type.'&type_instance='.$type_instance.'&category='.$cat.'&start='.$start.'&end='.$end.'" />';
                }
            }

            return \View::make('lcgp::plugins')->with(array('host' => $host, 'plugins' => $plugins, 'graphs' => $graphs, 'start' => $start, 'end' => $end));
        }

        public function graph($host, $plugin){

            // convert POSTed start and end times to GETs
            if(isset($_POST['start']))
                $_GET['start'] = strtotime($_POST['start']);

            if(isset($_POST['end']))
                $_GET['end'] = strtotime($_POST['end']);

            $end = isset($_GET['end']) ? $_GET['end'] : time();
            $start = isset($_GET['start']) ? $_GET['start'] : $end - 86400;

            $collectd = new Collectd(\Config::get('lcgp::collectd.datadir'));
            $plugins = $collectd->plugins($host);
            $data = $collectd->pluginData($host, $plugin);
            $data = $collectd->groupPlugins($data);
            $data = $collectd->sortPlugins($data);

            $graphs = array();
            foreach($data as $d){
                $plugin = $d['plugin'];
                $_GET['category'] = $cat = (isset($d['category'])) ? $d['category'] : NULL;
                $_GET['plugin_instance'] = $plugin_instance = (isset($d['plugin_instance'])) ? $d['plugin_instance'] : NULL;
                $_GET['type'] = $type = (isset($d['type'])) ? $d['type'] : NULL;
                $_GET['type_instance'] = $type_instance = (isset($d['type_instance'])) ? $d['type_instance'] : NULL;

                // if no PNG usage, get the canvas code ... otherwise use img tags
                if(!\Config::get('lcgp::collectd.png'))
                    include(__DIR__.'/../Spechal/Lcgp/plugins/'.$plugin.'.php');
                else
                    $graphs[$plugin][] = '<img src="/collectd/png/'.$host.'/'.$plugin.'?plugin_instance='.$plugin_instance.'&type='.$type.'&type_instance='.$type_instance.'&category='.$cat.'&start='.$start.'&end='.$end.'" />';
            }

            // $graph comes from the include
            return \View::make('lcgp::graph')->with(array('host' => $host, 'plugins' => $plugins, 'plugin' => $plugin, 'graphs' => $graphs, 'start' => $start, 'end' => $end));
        }

        /**
         * This is for the canvas output type
         * It will read the content of an RRD file for JS parsing
         * @param $file
         */
        public function rrd($file){
            $config = \Config::get('lcgp::collectd');
            $path = $config['datadir'];
            $file = str_replace('|', '/', $file);
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($file));
            // fix this cache setting later
            header("Expires: " .date(DATE_RFC822,strtotime(\Config::get('lcgp::collectd.cache')." seconds")));
            if(ob_get_length())
                ob_clean();
            flush();
            readfile($path . DIRECTORY_SEPARATOR . $file);
            exit;
        }

        /**
         * PNG support is busted and coded wrong
         * Needs refactored
         * -- this part outputs the image
         * -- need another part to output the img tags
         */
        public function png($host, $plugin){
            header("Expires: " . date(DATE_RFC822,strtotime(\Config::get('lcgp::collectd.cache')." seconds")));

            $_GET['category'] = (isset($_GET['category'])) ? $_GET['category'] : NULL;
            $_GET['plugin_instance'] = (isset($_GET['plugin_instance'])) ? $_GET['plugin_instance'] : NULL;
            $_GET['type'] = (isset($_GET['type'])) ? $_GET['type'] : NULL;
            $_GET['type_instance'] = (isset($_GET['type_instance'])) ? $_GET['type_instance'] : NULL;

            include(__DIR__.'/../Spechal/Lcgp/plugins/'.$plugin.'.php');
        }

        public function missingMethod($params){
            echo '<pre>'; print_r($params); exit;
        }

    }
