# @kfe
. ./configs

ip tunnel del tun1
subnet=$(($idx+1))
kgw_vip=192.168.$idx.1
# @kfe side
ip tunnel add tun1 mode ipip remote $kgw_ip dev eth0
ip addr add dev tun1 192.168.$idx.2/24
ip link set tun1 up

sh /root/routing.add

# @KGW side
ssh -i GW.pem ec2-user@$kgw_ip "/sbin/ip tunnel del tun$ridx ;/sbin/ip tunnel add tun$ridx mode ipip remote $kfe_ip dev eth0; /sbin/ip addr add dev tun$ridx 192.168.2.1/24; /sbin/ip link set tun$ridx up "
ping -c 5 $kgw_vip 2>&1 /dev/null  &
ssh -i GW.pem ec2-user@192.168.$ridx.1 "ping -c5 192.168.$r.2"

#iptables -t mangle -A PREROUTING -m owner --uid-owner kannel -j MARK --set-mark 0x01
#ip route add default dev $user_if src $user_if_local_ip table $user_table
#ip rule add type unicast fwmark $usermark priority 100 table $user_table
