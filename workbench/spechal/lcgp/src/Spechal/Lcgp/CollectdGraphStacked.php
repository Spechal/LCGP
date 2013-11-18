<?php

    /**
     * Most of this stuff is copy/modified from CGP v4
     */

    namespace Spechal\Lcgp;

    use Whoops\Example\Exception;

    class CollectdGraphStacked extends CollectdGraphDefault {

        protected function _rrd_gen_graph($png = FALSE){
            $rrdgraph = $this->_rrd_options($png);

            $sources = $this->_rrd_sources();

            $raw = null;
            if ($this->_scale)
                $raw = '_raw';
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

            for ($i=count($sources)-1 ; $i>=0 ; $i--) {
                if ($i == (count($sources)-1))
                    $rrdgraph[] = sprintf('\'CDEF:area_%s=avg_%1$s\'', $this->_crc32hex($sources[$i]));
                else
                    $rrdgraph[] = sprintf('\'CDEF:area_%s=area_%s,avg_%1$s,+\'', $this->_crc32hex($sources[$i]), $this->_crc32hex($sources[$i+1]));
            }

            $c = 0;
            foreach ($sources as $source) {
                $source = $this->_realSource($source, $this->_colors);
                #$color = is_array($this->_colors) ? (isset($this->_colors[$source])?$this->_colors[$source]:$this->_colors[$c++]) : $this->_colors;
                $color = $this->_realColor($source, $this->_colors);
                $color = $this->_faded_color($color);
                $rrdgraph[] = sprintf('\'AREA:area_%s#%s\'', $this->_crc32hex($source), $color);
            }

            $c = 0;
            foreach ($sources as $source) {
                $source = $this->_realSource($source, $this->_colors);
                $dsname =  (!empty($this->_ds_names[$source])) ? $this->_ds_names[$source] : $source;
                #$color = is_array($this->_colors) ? (isset($this->_colors[$source])?$this->_colors[$source]:$this->_colors[$c++]) : $this->_colors;
                $color = $this->_realColor($source, $this->_colors);
                $rrdgraph[] = sprintf('\'LINE1:area_%s#%s:%s\'', $this->_crc32hex($source), $color, $this->_rrd_escape($dsname));
                $rrdgraph[] = sprintf('\'GPRINT:min_%s:MIN:%s Min,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:avg_%s:AVERAGE:%s Avg,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:max_%s:MAX:%s Max,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:avg_%s:LAST:%s Last\\l\'', $this->_crc32hex($source), $this->_rrd_format);
            }

            return $rrdgraph;
        }

    }