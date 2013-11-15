<?php

    /**
     * Most of this stuff is copy/modified from CGP v4
     */

    namespace Spechal\Lcgp;

    use Whoops\Example\Exception;

    class CollectdGraphUptime extends CollectdGraphDefault {

        protected function _rrd_gen_graph($png = FALSE){
            $rrdgraph = $this->_rrd_options($png);

            $sources = $this->_rrd_sources();

            $i=0;
            foreach ($this->_type_instances as $tinstance) {
                foreach ($this->_data_sources as $ds) {
                    $rrdgraph[] = sprintf('\'DEF:avg_%s=%s:%s:AVERAGE\'', $this->_crc32hex($sources[$i]), $this->_parse_filename($this->_files[$tinstance]), $ds);
                    $rrdgraph[] = sprintf('\'DEF:max_%s=%s:%s:MAX\'', $this->_crc32hex($sources[$i]), $this->_parse_filename($this->_files[$tinstance]), $ds);

                    $rrdgraph[] = sprintf('\'CDEF:c_avg_%s=avg_%1$s,86400,/\'', $this->_crc32hex($sources[$i]));
                    $rrdgraph[] = sprintf('\'CDEF:c_max_%s=max_%1$s,86400,/\'', $this->_crc32hex($sources[$i]));

                    $rrdgraph[] = sprintf('\'VDEF:v_avg_%s=c_avg_%1$s,AVERAGE\'', $this->_crc32hex($sources[$i]));
                    $rrdgraph[] = sprintf('\'VDEF:v_max_%s=c_max_%1$s,MAXIMUM\'', $this->_crc32hex($sources[$i]));

                    $i++;
                }
            }

            for ($i=count($sources)-1 ; $i>=0 ; $i--) {
                if ($i == (count($sources)-1))
                    $rrdgraph[] = sprintf('\'CDEF:area_%s=c_avg_%1$s\'', $this->_crc32hex($sources[$i]));
                else
                    $rrdgraph[] = sprintf('\'CDEF:area_%s=area_%s,c_avg_%1$s,+\'', $this->_crc32hex($sources[$i]), $this->_crc32hex($sources[$i+1]));
            }

            $c = 0;
            foreach ($sources as $source) {
                $color = is_array($this->_colors) ? (isset($this->_colors[$source])?$this->_colors[$source]:$this->_colors[$c++]) : $this->_colors;
                $color = $this->_faded_color($color);
                $rrdgraph[] = sprintf('\'AREA:area_%s#%s\'', $this->_crc32hex($source), $color);
            }

            $c = 0;
            foreach ($sources as $source) {
                $dsname = $this->_ds_names[$source] != '' ? $this->_ds_names[$source] : $source;
                $color = is_array($this->_colors) ? (isset($this->_colors[$source])?$this->_colors[$source]:$this->_colors[$c++]) : $this->_colors;

                //current value
                $rrdgraph[] = sprintf('\'LINE1:area_%s#%s:%s\'', $this->_crc32hex($source), $color, $this->_rrd_escape($dsname));
                $rrdgraph[] = sprintf('\'GPRINT:c_avg_%s:LAST:%s days\\l\'', $this->_crc32hex($source), $this->_rrd_format);

                //max value
                $rrdgraph[] = sprintf('\'LINE1:v_max_%s#FF0000:Maximum:dashes\'', $this->_crc32hex($source));
                $rrdgraph[] = sprintf('\'GPRINT:v_max_%s:%s days\\l\'', $this->_crc32hex($source), $this->_rrd_format);

                //avg value
                $rrdgraph[] = sprintf('\'LINE1:v_avg_%s#0000FF:Average:dashes\'', $this->_crc32hex($source));
                $rrdgraph[] = sprintf('\'GPRINT:v_avg_%s:%s days\\l\'', $this->_crc32hex($source), $this->_rrd_format);
            }

            return $rrdgraph;
        }

    }