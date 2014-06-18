<?php
/*
 +-------------------------------------------------------------------------+
 | Copyright (C) 2004-2010 The Cacti Group                                 |
 |                                                                         |
 | This program is free software; you can redistribute it and/or           |
 | modify it under the terms of the GNU General Public License             |
 | as published by the Free Software Foundation; either version 2          |
 | of the License, or (at your option) any later version.                  |
 |                                                                         |
 | This program is distributed in the hope that it will be useful,         |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of          |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           |
 | GNU General Public License for more details.                            |
 +-------------------------------------------------------------------------+
 | KannelBundle : is a backage to automate setup of kannels and it addons  |
 +-------------------------------------------------------------------------+
 | This code is designed, written, and maintained by the Cacti Group. See  |
 | about.php and/or the AUTHORS file for specific developer information.   |
 +-------------------------------------------------------------------------+
 |                                                |
 +-------------------------------------------------------------------------+
*/
session_start();
if( empty($_SESSION['sessionid']) /*|| !isset($_COOKIE["CCS_MON_IF_COOKIE"])*/){
	require_once  "Auth.php"  ;exit(11);
}

# TODO
# server date , http decoder and encoder , unicode converter

?>

<table width="100%" align="center">
        <tr>
                <td class="textArea">
                        <strong>CCS Monitor Interface.</strong>

                        <ul>

                                <strong>Bundle Addons ::</strong>
                                <li><a href="getkannels.php">Running Kannels: </a> Get snapshot of all System running kannels</li>
                        </ul>
                </td>
                <td class="textArea" align="right" valign="top">
                        <strong>Version <?php #print $config["cacti_version"];?></strong>
                </td>
        </tr>
</table>


