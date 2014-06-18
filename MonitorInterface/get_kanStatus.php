<?php

            session_start();
        if( empty($_SESSION['sessionid']) || !isset($_COOKIE["CCS_MON_IF_COOKIE"])){
                require_once  "Auth.php"  ;exit(11);
        }


                        $url = "http://localhost:" . $_GET["port"] . "/status?password=" . $_GET["pass"];
                        $output = file_get_contents($url) ;
                        foreach  (explode("\n",$output) as $i){
                                echo   $i . "</br>"  ;
                        }
?>
