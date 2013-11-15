<?php

    /**
     * Most of this stuff is copy/modified from CGP v4
     */

    namespace Spechal\Lcgp;

    use Whoops\Example\Exception;

    class CollectdGraphIO extends CollectdGraphDefault {

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
                    $rrdgraph[] = sprintf('\'DEF:avg_%s_raw=%s:%s:AVERAGE\'', $this->_crc32hex($sources[$i]), $this->_parse_filename($this->_files[$tinstance]), $ds);
                    $rrdgraph[] = sprintf('\'DEF:max_%s%s=%s:%s:MAX\'', $this->_crc32hex($sources[$i]), $raw, $this->_parse_filename($this->_files[$tinstance]), $ds);
                    if (!$this->_scale)
                        $rrdgraph[] = sprintf('\'VDEF:tot_%s=avg_%1$s,TOTAL\'', $this->_crc32hex($sources[$i]));
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
                        if ($i == 1)
                            $rrdgraph[] = sprintf('\'CDEF:avg_%s_neg=avg_%1$s_raw,%s%s,*\'', $this->_crc32hex($sources[$i]), $this->_negative_io ? '-' : '', $this->_scale);
                        $rrdgraph[] = sprintf('\'VDEF:tot_%1$s=avg_%1$s,TOTAL\'', $this->_crc32hex($sources[$i]));
                        $i++;
                    }
                }
            }

            $rrdgraph[] = sprintf('\'CDEF:overlap=avg_%s,avg_%s_neg,LT,avg_%1$s,avg_%2$s_neg,IF\'',
                $this->_crc32hex($sources[0]), $this->_crc32hex($sources[1]));

            $i = 0;
            foreach($sources as $source) {
                $source = $this->_realSource($source, $this->_colors);
                $rrdgraph[] = sprintf('\'AREA:avg_%s%s#%s\'', $this->_crc32hex($source), $i == 1 ? '_neg' : '', $this->_faded_color($this->_colors[$source]));
                $i++;
            }

            $rrdgraph[] = sprintf('\'AREA:overlap#%s\'',
                $this->_faded_color(
                    $this->_faded_color($this->_colors[$this->_realSource($sources[0], $this->_colors)]),
                    $this->_faded_color($this->_colors[$this->_realSource($sources[1], $this->_colors)])
                )
            );

            $i = 0;
            foreach($sources as $source) {
                $source = $this->_realSource($source, $this->_colors);
                $dsname = $this->_ds_names[$source] != '' ? $this->_ds_names[$source] : $source;
                $rrdgraph[] = sprintf('\'LINE1:avg_%s%s#%s:%s\'', $this->_crc32hex($source), $i == 1 ? '_neg' : '', $this->_colors[$source], $this->_rrd_escape($dsname));
                $rrdgraph[] = sprintf('\'GPRINT:min_%s:MIN:%s Min,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:avg_%s:AVERAGE:%s Avg,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:max_%s:MAX:%s Max,\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:avg_%s:LAST:%s Last\'', $this->_crc32hex($source), $this->_rrd_format);
                $rrdgraph[] = sprintf('\'GPRINT:tot_%s:%s Total\l\'',$this->_crc32hex($source), $this->_rrd_format);
                $i++;
            }

            return $rrdgraph;
        }

    }