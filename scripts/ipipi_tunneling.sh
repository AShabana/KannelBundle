# @kfe
ip tunnel del tun1
kgw_ip=50.17.243.149
kfe_ip=107.20.205.7
usermark=0x01

ip tunnel add tun1 mode ipip remote $kgw_ip dev eth0
ip addr add dev tun1 192.168.0.2/24
ip link set tun1 up

ip route add 10.122.193.172 dev tun1
ip route add 10.122.196.172 dev tun1

ping -c 5 192.168.0.1 2>&1 /dev/null  &
ssh -i GW.pem ec2-user@192.168.0.1 "ping -c5 192.168.0.2"

#iptables -t mangle -A PREROUTING -m owner --uid-owner kannel -j MARK --set-mark 0x01
#ip route add default dev $user_if src $user_if_local_ip table $user_table
#ip rule add type unicast fwmark $usermark priority 100 table $user_table
