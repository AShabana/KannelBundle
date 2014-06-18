<?php

            session_start();
        if( empty($_SESSION['sessionid']) || !isset($_COOKIE["CCS_MON_IF_COOKIE"])){
                require_once  "Auth.php"  ;exit(11);
        }


                        $url = "http://localhost:" . $_GET["port"] . "/status?password=" . $_GET["pass"];
                        #echo "We are here.....................</br>";
                        #$ch = curl_init($url);
                        #curl_setopt($ch, CURLOPT_HEADER, 0);
                        #curl_setopt($ch, CURLOPT_POST, 1);
                        #curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        #$output = curl_exec($ch);
                        #curl_close($ch);
                        #echo  "$Conf[$i]</br>";
                        $output = file_get_contents($url) ;
                        foreach  (explode("\n",$output) as $i){
                                echo   $i . "</br>"  ;
                        }
?>
