<?php

    /**
     * Most of this stuff is copy/modified from CGP v4
     */

    namespace Spechal\Lcgp;

    use Whoops\Example\Exception;

    class CollectdGraphDefault {

        protected $_datadir, $_rrdtool, $_rrdtool_opts, $_cache, $_args, $_seconds = NULL;
        protected $_order, $_ds_names, $_rrd_title, $_rrd_vertical, $_rrd_format = NULL;
        protected $_graph_type, $_negative_io, $_graph_smooth, $_files, $_type_instances, $_identifiers = NULL;
        protected $_scale = 1;
        protected $_data_sources = array('value');
        protected $_width = 400;
        protected $_height = 175;

        protected $_png = FALSE;

        protected $_start = NULL;
        protected $_end = NULL;

        protected $_config = NULL;
        #protected $_colors = array('value' => '0000FF');
        protected $_colors = array();

        public function __construct($config){
            // setup config stuff
            if(!is_array($config))
                throw new Exception('Invalid configuration options.');

            $this->_datadir = $config['datadir'];
            $this->_rrdtool = $config['rrdtool'];
            $this->_rrdtool_opts = $config['rrdtool_opts'];
            $this->_cache = $config['cache'];
            $this->_width = $this->_get('width', $config['width']);
            $this->_height = $this->_get('height', $config['height']);
            $this->_graph_type = $config['graph_type'];
            $this->_negative_io = $config['negative_io'];
            $this->_graph_smooth = $config['graph_smooth'];

            if(isset($config['png']) && $config['png'] == TRUE)
                $this->_png = TRUE;

            // this replaces Type_Default->parse_get() in CGP v4
            $this->_args = array(
                'host' => $config['host'],
                'plugin' => $config['plugin'],
                'plugin_instance' => $this->_get('plugin_instance', NULL),
                'category' => $this->_get('category', NULL),
                'type' => $this->_get('type', NULL),
                'type_instance' => $this->_get('type_instance', NULL)
            );
            $this->_seconds = $this->_get('seconds', 86400);

            $this->_start = $this->_get('start', strtotime('yesterday'));
            $this->_end = $this->_get('end', 'now');

            // do other constructor stuff

            // build up the type instances and files list
            // - replaces Type_Default->rrd_files() in CGP v4
            $files = $this->_get_filenames();
            foreach($files as $key => $file){
                $basename = basename($file, '.rrd');
                $instance = strpos($basename, '-') ? substr($basename, strpos($basename,'-') + 1) : 'value';
                $this->_type_instances[] = $instance;
                $this->_files[$instance] = $file;
            }
            sort($this->_type_instances);
            ksort($this->_files);

            $this->_identifiers = $this->_file2identifier($this->_files);
        }

        /**
         * Create a hex value from a CRC of a string
         *
         * @param $string
         * @return string
         */
        protected function _crc32hex($string){
            return sprintf("%x", crc32($string));
        }

        /**
         * Create an array of colors
         */
        protected function _rainbow_colors(){
            $c = 0;
            $sources = $this->_rrd_sources();
            $total_sources = count($sources);
            foreach ($sources as $ds) {
                # hue (saturnation=1, value=1)
                $h = $total_sources > 1 ? 360 - ($c * (330/($total_sources-1))) : 360;

                $h = ($h %= 360) / 60;
                $f = $h - floor($h);
                $q[0] = $q[1] = 0;
                $q[2] = 1*(1-1*(1-$f));
                $q[3] = $q[4] = 1;
                $q[5] = 1*(1-1*$f);

                $hex = '';
                foreach(array(4,2,0) as $j) {
                    $hex .= sprintf('%02x', $q[(floor($h)+$j)%6] * 255);
                }
                $this->_colors[$ds] = $hex;
                $c++;
            }
        }

        /**
         * Generate a hex color that is faded X percent
         *
         * @param $foreground_color
         * @param string $background_color
         * @param float $percent
         * @return string
         */
        protected function _faded_color($foreground_color, $background_color = 'FFFFFF', $percent = 0.25){
            if(!is_numeric($percent))
                $percent = 0.25;

            $rgb = array('r', 'g', 'b');

            $fg['r'] = hexdec(substr($foreground_color,0,2));
            $fg['g'] = hexdec(substr($foreground_color,2,2));
            $fg['b'] = hexdec(substr($foreground_color,4,2));
            $bg['r'] = hexdec(substr($background_color,0,2));
            $bg['g'] = hexdec(substr($background_color,2,2));
            $bg['b'] = hexdec(substr($background_color,4,2));

            foreach ($rgb as $pri) {
                $c[$pri] = dechex(round($percent * $fg[$pri]) + ((1.0 - $percent) * $bg[$pri]));
                if ($c[$pri] == '0')
                    $c[$pri] = '00';
            }

            return $c['r'].$c['g'].$c['b'];
        }

        /**
         * Get the instance identifier from the file name
         *
         * @param $files
         * @return mixed
         */
        protected function _file2identifier($files){
            foreach($files as $key => $file){
                if (is_file($file)){
                    $files[$key] = preg_replace('#^'.$this->_datadir.'/#u', '', $files[$key]);
                    $files[$key] = preg_replace('#\.rrd$#', '', $files[$key]);
                }
            }
            return $files;
        }

        /**
         * Escape the colon
         *
         * @see  http://oss.oetiker.ch/rrdtool/doc/rrdgraph_graph.en.html#IEscaping_the_colon
         * @param $value
         * @return mixed
         */
        protected function _rrd_escape($value){
            if(!$this->_png)
                return str_replace(':', '\:', $value);
            else
                return str_replace(':', '\\\:', $value);
        }

        /**
         * Generates a URL to the graph
         *
         * @param $name
         * @return mixed
         */
        protected function _parse_filename($name){
            if(!$this->_png){
                $name = str_replace($this->_datadir . '/', '', $name);
                # rawurlencode all but /
                $name = str_replace('%2F', '/', rawurlencode($name));
                // change slashes into pipes
                $name = str_replace('/', '%7C', $name);
                return $this->_rrd_escape('/collectd/rrd/file/'.$name, $this->_png);
            } else {
                $name = str_replace(array(' ', '(', ')'), array('\ ', '\(', '\)'), $name);
                return $this->_rrd_escape($name, $this->_png);
            }
        }

        /**
         * Get the file names for the plugin instance
         *
         * @return array
         */
        protected function _get_filenames(){
            $identifier = sprintf('%s/%s%s%s%s%s/%s%s%s',
                $this->_args['host'],
                $this->_args['plugin'],
                strlen($this->_args['category']) ? '-' : '', $this->_args['category'],
                strlen($this->_args['plugin_instance']) ? '-' : '', $this->_args['plugin_instance'],
                $this->_args['type'],
                strlen($this->_args['type_instance']) ? '-' : '', $this->_args['type_instance']
            );

            $wildcard = strlen($this->_args['type_instance']) ? '.' : '[-.]*';
            $files = glob($this->_datadir .'/'. $identifier . $wildcard . 'rrd');

            return $files;
        }

        /**
         * RRD graph options
         *
         * @return array
         */
        protected function _rrd_options(){
            $rrdgraph = array();

            if($this->_png){
                $rrdgraph[] = $this->_rrdtool;
                $rrdgraph[] = 'graph - -a PNG';
            }

            // include passed in options
            if(!empty($this->_rrdtool_opts) && is_array($this->_rrdtool_opts))
                foreach($this->_rrdtool_opts as $k => $v)
                    $rrdgraph[] = $v;

            // for graph smoothing
            if($this->_graph_smooth)
                $rrdgraph[] = '-E';

            // width
            $rrdgraph[] = sprintf('-w %d', is_numeric($this->_width) ? $this->_width : 400);
            // height
            $rrdgraph[] = sprintf('-h %d', is_numeric($this->_height) ? $this->_height : 175);
            // lower limit
            $rrdgraph[] = '-l 0';
            // title
            $rrdgraph[] = sprintf('-t \'%s on %s\'', $this->_rrd_title, $this->_args['host']);
            // vertical
            if ($this->_rrd_vertical)
                $rrdgraph[] = sprintf('-v \'%s\'', $this->_rrd_vertical);
            // start / end
            if(!$this->_png){
                #$rrdgraph[] = sprintf('-s e-%d', is_numeric($this->_seconds) ? $this->_seconds : 86400);
                if(is_numeric($this->_start))
                    $rrdgraph[] = sprintf('--start %d', $this->_start);

                if(is_numeric($this->_end))
                    $rrdgraph[] = sprintf('--end %d', $this->_end);

            } else {
                if(is_numeric($this->_start))
                    $rrdgraph[] = sprintf('--start %d', $this->_start);
                else
                    $rrdgraph[] = sprintf('--start -86400');

                if(is_numeric($this->_end))
                    $rrdgraph[] = sprintf('--end %d', $this->_end);
                else
                    $rrdgraph[] = sprintf('--end now');
            }

            return $rrdgraph;
        }

        /**
         * Get the source files for the data
         *
         * @return array
         */
        protected function _rrd_sources(){
            if(is_array($this->_files) && count($this->_files) > 1){
                // source is in multiple files
                if(is_array($this->_order))
                    $this->_type_instances = array_merge(array_intersect($this->_order, $this->_type_instances));

                // use type instances as sources
                if(is_array($this->_data_sources) && count($this->_data_sources) > 1){
                    $sources = array();
                    foreach($this->_type_instances as $x){
                        foreach($this->_data_sources as $y){
                            $sources[] = $x . '-' . $y;
                        }
                    }
                } else {
                    $sources = $this->_type_instances;
                }
            } else {
                // source is in a single file
                if(is_array($this->_data_sources) && count($this->_data_sources) == 1 && in_array('value', $this->_data_sources)){
                    $sources = $this->_type_instances;
                    #$sources = $this->_data_sources;
                } else {
                    #$sources = $this->_type_instances;
                    $sources = $this->_data_sources;
                }
            }

            $this->_parse_ds_names($sources);

            return $sources;
        }

        /**
         * Get the Data Source names
         *
         * @param $sources
         */
        protected function _parse_ds_names($sources){
            // fill ds names if not supplied by plugin
            if(!is_array($this->_ds_names))
                $this->_ds_names = array_combine($sources, $sources);

            // find longest ds name
            $length = 0;
            foreach($this->_ds_names as $key => $value)
                if(strlen((string)$value) > $length)
                    $length = strlen((string)$value);

            // max ass data source names equal in length
            $format = sprintf("%%-%ds", $length);
            foreach($this->_ds_names as $key => $value)
                $this->_ds_names[$key] = sprintf($format, $value);
        }

        protected function _rrd_gen_graph(){
            $rrdgraph = $this->_rrd_options();

            $sources = $this->_rrd_sources();

            if ($this->_scale)
                $raw = '_raw';
            else
                $raw = null;

            $i=0;
            foreach ($this->_type_instances as $tinstance) {
                foreach ($this->_data_sources as $ds) {
                    $rrdgraph[] = sprintf('\'DEF:min_%s%s=%s:%s:MIN\'', $this->_crc32hex($sources[$i]), $raw, $this->_parse_filename($this->_files[$tinstance]), $ds);
                    $rrdgraph[] = sprintf('\'DEF:avg_%s%s=%s:%s:AVERAGE\'', $this->_crc32hex($sources[$i]), $raw, $this->_parse_filename($this->_files[$tinstance]), $ds);
                    $rrdgraph[] = sprintf('\'DEF:max_%s%s=%s:%s:MAX\'', $this->_crc32hex($sources[$i]), $raw, $this->_parse_filename($this->_files[$tinstance]), $ds);
                    $i++;
                }
            }
            if ($this->_scale) {
                $i=0;
                foreach ($this->_type_instances as $tinstance) {
                    foreach ($this->_data_sources as $ds) {
                        $rrdgraph[] = sprintf('\'CDEF:min_%s=min_%1$s_raw,%s,*\'', $this->_crc32hex($sources[$i]), $this->_scale);
                        $rrdgraph[] = sprintf('\'CDEF:avg_%s=avg_%1$s_raw,%s,*\'', $this->_crc32hex($sources[$i]), $this->_scale);
                        $rrdgraph[] = sprintf('\'CDEF:max_%s=max_%1$s_raw,%s,*\'', $this->_crc32hex($sources[$i]), $this->_scale);
                        $i++;
                    }
                }
            }

            if(count($this->_files)<=1) {
                $c = 0;
                foreach ($sources as $source) {
                    $color = is_array($this->_colors) ? (isset($this->_colors[$source])?$this->_colors[$source]:$this->_colors[$c++]): $this->_colors;
                    $rrdgraph[] = sprintf('\'AREA:max_%s#%s\'', $this->_crc32hex($source), $this->_faded_color($color));
                    $rrdgraph[] = sprintf('\'AREA:min_%s#%s\'', $this->_crc32hex($source), 'ffffff');
                    break; # only 1 area to draw
                }
            }

            $c = 0;
            foreach ($sources as $source) {
                $dsname = (!empty($this->_ds_names[$source])) ? $this->_ds_names[$source] : $source;
                $color = is_array($this->_colors) ? (isset($this->_colors[$source]) ? $this->_colors[$source] : $this->_colors[$c++]) : $this->_colors;
                $rrdgraph[] = sprintf('\'LINE1:avg_%s#%s:%s\'', $this->_crc32hex($source), $color, $this->_rrd_escape($dsname));
                $rrdgraph[] = sprintf('\'GPRINT:min_%s:MIN:%s Min,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:avg_%s:AVERAGE:%s Avg,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:max_%s:MAX:%s Max,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:avg_%s:LAST:%s Last\\l\'', $this->_crc32hex($source), $this->_rrd_format);
            }

            return $rrdgraph;
        }

        /**
         * Generate the code needed to display the RRD graph
         *
         * @return string
         */
        public function rrd_graph(){
            if(empty($this->_colors) || count($this->_colors) == 1)
                $this->_rainbow_colors();

            $data = $this->_rrd_gen_graph($this->_png);

            #echo implode(' ', $data); exit;

            $return = NULL;
            if(!$this->_png){
                $return .= '<canvas id="'.sha1(serialize($data)).'" class="rrd">';
                foreach($data as $value)
                    $return .= "$value ";
                $return .= '</canvas>';
            } else {
                header("content-type: image/png");
                $return = implode(' ', $data);

                echo `$return`;

                return true;
            }

            return $return;
        }

        public function setDataSources($data){
            $this->_data_sources = $data;
            return $this;
        }

        public function setDataSourceNames($data){
            $this->_ds_names = $data;
            return $this;
        }

        public function setTitle($data){
            $this->_rrd_title = $data;
            return $this;
        }

        public function setVertical($data){
            $this->_rrd_vertical = $data;
            return $this;
        }

        public function setFormat($data){
            $this->_rrd_format = $data;
            return $this;
        }

        public function setColors($colors){
            if(is_array($colors))
                $this->_colors = $colors;
            return $this;
        }

        public function setScale($num){
            $this->_scale = $num;
            return $this;
        }

        public function getArg($name){
            if(isset($this->_args[$name]))
                return $this->_args[$name];
            return false;
        }

        public function addRRDOption($value){
            $this->_rrdtool_opts[] = $value;
            return $this;
        }

        public function setOrder($array){
            $this->_order = $array;
            return $this;
        }

        protected function _get($value, $default = FALSE){
            if(isset($_GET[$value]))
                return $_GET[$value];
            else
                return $default;
        }

        protected function _realSource($source, $colors){
            if(!is_array($this->_colors))
                return FALSE;

            if(in_array($source, array_keys($colors)))
                return $source;

            $tmp = explode('-', $source);
            if(!isset($tmp[1]))
                if(!empty($colors['value']))
                    return $source;

            if(!empty($tmp[0]) && strlen($tmp[0]) > 1)
                $source = $tmp[0];
            // try to get the color from $tmp[0] ... if not, try $tmp[1] ... if not, fall back
            if(!in_array($source, array_keys($colors)) && in_array($tmp[1], array_keys($colors)))
                $source = $tmp[1];

            return (!empty($source)) ? $source : FALSE;
        }

        protected function _realColor($source, $colors){
            if(!in_array($source, $colors) && isset($colors['value']))
                return $colors['value'];
            else
                return $colors[$source];
        }

    }