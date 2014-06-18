<html>
  <head>
    <p id="demo"></p>
  </head>
  <body>
    <script>
      function myFunction(smsc,port)
      {
        var x;
        var mobile_number=prompt("Please enter your a mobile number to send test sms with","201003325373");
        if (mobile_number!=null)
        {
          var xmlhttp;
          if (window.XMLHttpRequest)
          {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
          }
          else
          {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange=function()
          {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
              document.getElementById("demo").innerHTML=xmlhttp.responseText;
            }
          }
          xmlhttp.open("POST","send_and_lookup.php",true);
          xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
          xmlhttp.send("port="+port+"&from="+mobile_number+"&smsc="+smsc);
        }
      }
    </script>
    <?php
    session_start();
    if( empty($_SESSION['sessionid']) ){
        require_once  "Auth.php"  ;
        exit(11);
}


        $status = simplexml_load_file("http://localhost:" . $_GET["port"] . "/status.xml?password=" . $_GET["pass"]);
        foreach ($status->smscs->smsc as $smsc)
        {
                print  "<b>$smsc->id:</b>".$smsc->{'admin-id'}  . " ( ".$smsc->status." ) [  <a href=http://localhost:".$_GET["port"]."/stop-smsc.html?password=".$_GET["pass"]."&smsc=".$smsc->{'admin-id'}."> Stop </a> ]" ;
                print  "[  <a href=http://localhost:".$_GET["port"]."/start-smsc.html?password=".$_GET["pass"]."&smsc=".$smsc->{'admin-id'}."> Start </a>]" ;
                print  "<button onclick=\"myFunction('".$smsc->id."','".$_GET['port']."')\">Send test SMS</button>"  ;
                print "</br>" ;
        }

  ?>
  </body>
</html>
