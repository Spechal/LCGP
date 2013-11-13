## Laravel Collectd Graph Panel

LCGP is pretty much a port of CGP v4 to Laravel.

See https://github.com/pommi/CGP/ for CGP

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
- [ ] df (currently shows a graph for each data source instead of merging them -- issues with PNG support)
- [x] disk
- [ ] dns
- [x] entropy
- [ ] filecount
- [ ] hddtemp
- [ ] interface (issues with PNG support)
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