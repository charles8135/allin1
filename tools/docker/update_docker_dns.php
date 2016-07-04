<?php
date_default_timezone_set("Asia/Shanghai");

function get_dns_conf() {
    $get_list_cmd = "docker ps";
    exec($get_list_cmd, $res, $ret);
    if ($ret != 0) {
        echo "[ERROR] $get_list_cmd error..." . "\n";
        return ""; 
    }
    array_shift($res);
    $dns_conf = array();
    foreach($res as $v) {
        $res = array();
        $ret = -1;
        $id = substr($v, 0, 12);
        $info_cmd = "docker inspect $id";
        exec($info_cmd, $res, $ret);
        if ($ret != 0) {
            echo "[ERROR] $info_cmd $id error..." . "\n";
            continue;
        }
        $res = implode(' ', $res);
        $docker_info = json_decode($res, true);
        $docker_name = trim($docker_info[0]['Name'], '/');
        $docker_ip = $docker_info[0]['NetworkSettings']['IPAddress'];
        $dns_conf[$docker_name]['ip'] = $docker_ip;
    }
    return $dns_conf;
}

function update_dns_conf($dns_conf) {
    if (empty($dns_conf)) {
        echo "[ERROR] dns info empty...\n";
    }
    ksort($dns_conf);
    $dns_str = "";
    foreach($dns_conf as $name => $one) {
        $dns_str .= "${one['ip']} $name\n";
    }

    $conf_file = "/etc/dnsmasq.hosts";
    $cur_conf_str = file_get_contents($conf_file);
    if ($cur_conf_str == $dns_str) {
        echo "[INFO] dnsmasq hosts same...\n";
        return 0;
    }

    file_put_contents($conf_file, $dns_str);
    $restart_cmd = "service dnsmasq restart";
    exec($restart_cmd, $res, $ret);
    
    echo $dns_str;
    if ($ret != 0) {
        echo "[ERROR] dnsmasq restart fail...\n";
        return 1;
    } else {
        echo "[OK] dnsmasq restart ok...\n";
    }
}

function main() {
    $timeout = 1000 * 1000;
    while(true) {
        $time = date('Y-m-d H:i:s', time());
        echo "\n[INFO] [$time] update dns begin...\n";
        $dns_conf = get_dns_conf();
        update_dns_conf($dns_conf);
        $time = date('Y-m-d H:i:s', time());
        echo "[INFO] [$time] update dns end...\n";
        usleep($timeout);
    }
}

// ### Main ###
main();
