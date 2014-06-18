<?php
    session_start();
    if( empty($_SESSION['sessionid']) /*|| !isset($_COOKIE["CCS_MON_IF_COOKIE"])*/){
      require_once  "Auth.php"  ;
      exit(11);
    }

    $url = "http://localhost:" . $_GET["port"] . "/store-status.html?password=" . $_GET["pass"];
    $output = file_get_contents($url);
    echo $output ;

?>
