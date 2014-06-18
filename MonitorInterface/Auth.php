<?php
	session_start();
	if(empty($_SESSION['sessionid'])){
		include 'auth_form.html' ;
		if(  isset($_POST["Fname"]) && isset($_POST["Lname"]) && $_POST["Lname"] != ""){
			 $config = parse_ini_file("config.ini",true) ;
			if ( function_exists("ldap_connect")){
			    $ldap = ldap_connect($config["ldap"]["host"]);
			    ldap_bind($ldap, $_POST['Fname'], $_POST['Lname']);
			    print "Sucesss ..<br/>";
			    setcookie("CCS_MON_IF_COOKIE",$sid, time()+3600*12);
			    $_SESSION['sessionid'] = session_id();
			    header( 'Location:index.php');
			    
			}
			elseif( $_POST["Fname"] == $config["glabal"]["admin"] &&  $config["global"]["admin_password"] == $_POST['Lname']  ) { 
				print "Sucesss ..<br/>";
				session_start();
				$sid = session_id() ;
				setcookie("CCS_MON_IF_COOKIE",$sid, time()+3600*12);
				$_SESSION['sessionid'] = session_id();
		    		header( 'Location:index.php');
		 } 
		 else {
	        	print "Login failed ..";
			      exit(0);
      }
    }  
	}
?>
