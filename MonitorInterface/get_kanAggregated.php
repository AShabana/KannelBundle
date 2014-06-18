<?php

                session_start();
                if( empty($_SESSION['sessionid'])){
                                require_once  "Auth.php"  ;exit(11);
                }
# T.D
# 1. Aggregate all Kannels status
################################################### Collecting Data stage .
                $status = simplexml_load_file ("http://localhost:".$_GET["port"]."/status.xml?password=".$_GET["pass"]);

       echo "<p >Kannel Up Time : <span style='color:red;font-size:19px;'>".$status->status."</span></p>";
       echo "<p >Total Sent :<span style='color:green;font-size:19px;'> :".$status->sms->sent->total."Sms</span></p>";

                $SMSC = array() ;

                foreach ($status->smscs->smsc as $smsc)
                {
                  $SMSC[(string) $smsc->id]["SESSIONS"] += 1 ;
                  if ( strstr($smsc->status, "online")) {
                         $SMSC["online"][(string) $smsc->id]["FAILED"] += $smsc->failed ;
                         $SMSC["online"][(string) $smsc->id]["SENT"] += $smsc->sms->sent ;
                         $SMSC["online"][(string) $smsc->id]["DLR"] += $smsc->dlr->received ;
                         $SMSC["online"][(string) $smsc->id]["QUEUED"] += $smsc->queued ;
                  }
                  else {
                        $SMSC["offline"][(string) $smsc->id]["SESSIONS"] +=  1 ;
                  }
                }
        echo '<p><b><big><font size="5"> <font color="red" >Store Size: ' . $status->sms->storesize. '</font></big></b></p>' ;
###############################################################33
                echo '<p><b><big><font size="5"> <font color="red" >Down Links :-</font></big></b></p>' ;
                echo '<p><b><big><font size="5"> <font color="red" >-------------- </font></big></b></p>' ;
                foreach ( $SMSC["offline"] as $link => $sessions){
                        echo $link . " : " . $sessions["SESSIONS"] . " Session[s] / " .  $SMSC[$link]["SESSIONS"] . "  (" ;
                        if ( $sessions["SESSIONS"]/$SMSC[$link]["SESSIONS"] * 100 == 100 ){
                                echo '<font color="red" >' . round($sessions["SESSIONS"]/$SMSC[$link]["SESSIONS"] * 100, 2) . '%</font>' ;
                        }else{
                                echo round($sessions["SESSIONS"]/$SMSC[$link]["SESSIONS"]*100 ,2) . "%" ;
                        }
                        echo " Down) </p>";
                }
                //uasort($Failed_idx, "sortByFailed_idx") ; print_r($Failed_idx);
###############################################################
                echo '<p><b><big><font size="5"> <font color="red" >FAILED SUBMITS :-</font></big></b></p>' ;
                echo '<p><b><big><font size="5"> <font color="red" >--------------------</font></big></b></p>' ;
                foreach ( $SMSC["online"] as $link => $data){
                        if ( $data["FAILED"] > 0 ) {
                                echo $link . ": Contains : " . $data["FAILED"] . " Failed SMS  (" ;
                                if ( round($data["FAILED"]/$SMSC["online"][$link]["SENT"]*100,2) > 10 ){
                                         echo '<font color="red" >' . round($data["FAILED"]/$SMSC["online"][$link]["SENT"]*100,2) . '</font>' ;
                                }else{
                                        echo round($data["FAILED"]/$SMSC["online"][$link]["SENT"]*100,2) ;
                                }
                                echo "%) from its all traffic</p>" ;
                        }
                }
###############################################################
        echo '<p><b><big><font size="5"> <font color="red" >LINKS QUEUES :-</font></big></b></p>' ;
                echo '<p><b><big><font size="5"> <font color="red" >--------------------</font></big></b></p>' ;

                foreach ( $SMSC["online"] as $link => $data){
                        if ( $data["QUEUED"] > 0 ) {
                                echo $link . " Contains: " . $data["QUEUED"] . " Queued SMS</p>" ;
                        }
                }
###############################################################
        echo '<p><b><big><font size="5"> <font color="red" >LINKS DLR Ratios :-</font></big></b></p>' ;
                echo '<p><b><big><font size="5"> <font color="red" >--------------------</font></big></b></p>' ;
                $total_smsc_count = $status->smscs->count ;
                $table_colmns = round($total_smsc_count/10) > 0 ? round($total_smsc_count/10) : 10 ;
                $i = 0;
                echo "<table border=\"1\">";
                echo "<tr>";
                foreach ($SMSC["online"] as $link => $data ) {
                        # T.D Add check if this link support dlrs or not
                        if ( $SMSC["online"][$link]["DLR"] == 0 )
                                continue ;
                        if($i == 10) { echo "</tr>" ; $i = 0 ; echo "<tr>" ; }
                        $i++ ;
                        echo "<td>" . $link . " (" ;
                        if (round($SMSC["online"][$link]["DLR"]/$SMSC["online"][$link]["SENT"]*100) < 70 ) {
                                echo '<font color="red" >' . round($SMSC["online"][$link]["DLR"]/$SMSC["online"][$link]["SENT"]*100) . '%</font>' ;
                        }else{
                                echo round($SMSC["online"][$link]["DLR"]/$SMSC["online"][$link]["SENT"]*100) . "%" ;
                        }
                        echo ")</td>";
                }
                echo "</tr>" ;
                echo "</table>" ;
        ?>
<li><a href="index.php">Main Page</a> Return to your home</li>
