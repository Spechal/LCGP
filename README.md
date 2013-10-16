## Laravel Collectd Graph Panel

LCGP is pretty much a port of CGP v4 to Laravel.

See https://github.com/pommi/CGP/ for CGP

### To Do

- Refactor the code into a true package
- Fix routing and offset issues with some plugins
- Add groupings and categories back from the CGP v3 fork at https://github.com/Spechal/CGP
- Finish porting plugins
- [x] apache
- [ ] apcups
- [ ] battery
- [ ] bind
- [ ] conntrack
- [ ] contextswitch
- [x] cpu
- [ ] cpufreq
- [ ] df (currently shows a graph for each data source instead of merging them)
- [x] disk
- [ ] dns
- [ ] entropy
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
- [ ] ntpd (busted ... not sure why)
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
- [ ] vmem
- [ ] vserver
- [ ] wireless
- [ ] zfs_arc