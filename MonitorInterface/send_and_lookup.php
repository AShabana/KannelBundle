<?php
        session_start();
        if( empty($_SESSION['sessionid']) ){
        require_once  "Auth.php"  ;exit(11);
        }

        $config = parse_ini_file("config.ini",true) ;
        # Search for log of the sent sms in its proper log-file
        # Get conf file
        $cmd = "egrep -l '^admin-port[[:space:]]*=[[:space:]]*" . $_POST['port'] . "' " . $config["global"]["kannel_config_path"] . "/*.conf  ";
        $conf_file = exec($cmd);
        # DEBUG echo $conf_file ;
        $cmd = "egrep -m1 '^sendsms-port[[:space:]]*=[[:space:]]*[[:digit:]]+' ". $conf_file." | cut -d'=' -f2" ;
        $sendsms_port = trim(exec($cmd)) ;
        # Send SMS number
        $url = 'http://localhost' .$sendsms_port.'/cgi-bin/sendsms?username=nemra1&password=koko88&smsc='.$_POST['smsc'].'&from=TestLink&to='.$_POST['from'].'&text=test&coding=0' ;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        echo $output ;
        curl_close($ch);
        # search for sent SMS at the log file
        $cmd = "egrep -m1 '^access-log[[:space:]]*=[[:space:]]*\W+' ". $conf_file." | cut -d'=' -f2 \n" ;
        $log_file = exec($cmd) ;
        #echo $log_file ;
        #$cmd = "grep -h -m 100 '".$_POST['from']."' ".$log_file."\n" ;
        $cmd = "tail ".$log_file." | grep -h '".$_POST['from']."' \n" ;
        #DEBUG echo "</br>".$cmd."</br>" ;
        echo "<pre>$cmd</pre>";
        exec($cmd, $o );
        sleep(1) ;
        echo "</br>";
        echo "<pre>";
        print_r($o) ;
        echo "</pre>" ;
?>
