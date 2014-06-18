<?php
        # TODO : include header and footer
        session_start();
        if( empty($_SESSION['sessionid']) /*|| !isset($_COOKIE["CCS_MON_IF_COOKIE"])*/){
                require_once  "Auth.php"  ;exit(11);
        }
        $appConf = parse_ini_file("config.ini") ;
        $Conf = array();

        exec('/bin/ps aux | awk \'/bearerbox/{ if($0 !~ "awk") print $NF } \'' ,$Conf) ;


        print "<br>You have: <b>" . count($Conf) . "</b> Running kannels on this system IP:<span style='text-decoration:underline;'>". $appConf['server'] ."</span>";
        print "<br>Which are: <br>" ;
        for($i=0; $i<count($Conf); $i++)
        {
                $port = exec("grep '^admin-port' $Conf[$i] | cut -d'=' -f2 | sed 's/ //g'");
                $pass = exec("grep '^status-password' $Conf[$i] | cut -d'=' -f2 | sed 's/ //g'");
                print  $i+1  . ")) $Conf[$i] [ <a href=http://" . $appConf['global']['portal_host'] . $appConf['global']['portal_port'] . "/get_kanStatus.php?pass=$pass&port=$port> Status </a>]
                                             [ <a href=http://" . $appConf['global']['portal_host'] . $appConf['global']['portal_port'] . "/get_kanStore.php?pass=$pass&port=$port> Store </a>]
                                             [ <a href=http://" . $appConf['global']['portal_host'] . $appConf['global']['portal_port'] . "/get_kanStatus_v2.php?pass=$pass&port=$port> Contole links </a>]
                                             [ <a href=http://" . $appConf['global']['portal_host'] . $appConf['global']['portal_port'] . "/_get_kanAggregated.php?pass=$pass&port=$port> Aggregated by status snapshot </a>]
                                             [ <a href=http://" . $appConf['global']['portal_host'] . $appConf['global']['portal_port'] . "/lookup.php> Look inside BB current access log"
                </br>" ;
                

        }
        
        
?>
<li><a href="index.php">Main Page</a> Return to your home</li>
