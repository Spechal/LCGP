## Laravel Collectd Graph Panel

LCGP is pretty much a port of CGP v4 to Laravel.

See https://github.com/pommi/CGP/ for CGP

### To install
This package is still in progress so it isn't published.

You can install Laravel 4 and copy over the files from workbench/spechal and then add Spechal\Lcgp\LcgpServiceProvider to your service providers array or upload the entire project to your web root.

You will need to modify the workbench/spechal/lcgp/src/config/config.php to point to your CollectD RRD files and rrdtool executable.

In addition, if LCGP is not being used stand-alone, you will need to change the main route in app/routes.php

### To Do

- Move newly added code back into the Laravel package
- Add groupings and categories back from the CGP v3 fork at https://github.com/Spechal/CGP
- Finish porting plugins
- [x] apache
- [ ] apcups
- [ ] battery
- [ ] bind
- [ ] conntrack
- [x] contextswitch
- [x] cpu
- [ ] cpufreq
- [ ] df (currently shows a graph for each data source instead of merging them)
- [x] disk
- [ ] dns
- [x] entropy
- [ ] filecount
- [ ] hddtemp
- [x] interface
- [ ] ip6tables
- [ ] iptables
- [x] irq
- [ ] libvirt
- [x] load
- [ ] md
- [x] memcached
- [x] memory
- [x] mysql
- [ ] netlink
- [x] nfs
- [ ] nginx
- [x] ntpd
- [ ] nut
- [ ] openvpn
- [ ] ping
- [ ] postgresql
- [ ] powerdns
- [x] processes
- [x] redis
- [ ] sensors
- [ ] snmp
- [x] swap
- [ ] tail
- [x] tcpconns
- [ ] thermal
- [x] uptime
- [x] users
- [x] varnish
- [x] vmem
- [ ] vserver
- [ ] wireless
- [ ] zfs_arc