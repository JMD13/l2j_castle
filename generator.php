<?php

//---------------
// Made by Daedalus email : daedalus at hotmail dot fr
//---------------

$db_serv = '127.0.0.1';			//the address of the database goes here

$db_user = 'root';				//your sql username goes here
$db_pass = '';					//your sql password goes here

$db_name = 'l2jdb';				//your database name goes here

$filename = './helios.js';		//generated javascript file you need to put attribute 777 in your folder

//-----------------------------------------------------------------------------------------------

@mysql_connect ( $db_serv, $db_user, $db_pass ) or die ('Coudn\'t connect to host');
@mysql_select_db( $db_name ) or die ('Couldn\'t select database');

$sql = @mysql_query('SELECT id,name,taxPercent,siegeDate,siegeHourOfDay FROM `castle`') or die('Query failed!');

$gen = "\n";

while ($castle = @mysql_fetch_array($sql))
{
	$gen .= "\n".strtolower($castle['name']) . 'info = \'<div class="castleWrapper">';
	$gen .= '<div class="castlePic" id="' . ucfirst(strtolower($castle['name'])) . 'Pic"></div>';
	$gen .= '<div class="castleInfo">';
	$gen .= '<div class="castleName"><strong>' . ucfirst(strtolower($castle['name'])) . ' Castle</strong></div>';
	
	$clan = @mysql_fetch_array(mysql_query('SELECT clan_name,hasCastle FROM `clan_data` WHERE hasCastle = ' . $castle['id']));
	$clan_name = (isset($clan['clan_name'])) ? htmlspecialchars($clan['clan_name'], ENT_QUOTES) : 'UNCLAIMED';
	
	$gen .= '<div><strong>Controlled by:</strong> ' . $clan_name . '</div>';
	
	if (isset($clan['clan_name'])) $gen .= '<div><strong>Tax Rate:</strong> ' . $castle['taxPercent'] . '%</div>';
	
	$gen .= '<div><strong>Next Siege:</strong> ' . date('M d Y ',$castle['siegeDate']/1000) . $castle['siegeHourOfDay'] . date(':00 T') . '</div>';
	$gen .= '</div></div>\';'."\n\n";
}

$handle = @fopen($filename, 'w+');
@fwrite($handle, $gen);
@fclose($handle);

?>