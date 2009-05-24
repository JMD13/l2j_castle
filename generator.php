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

$sql = @mysql_query('SELECT id,name,taxPercent,siegeDate FROM `castle`') or die('Query failed!');

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
	
	$gen .= '<div><strong>Next Siege:</strong> ' . date('M d Y h:iA ',$castle['siegeDate']/1000) . ' ' . date('T') . '</div>';
	$gen .= '</div>';
	
	// seed
	
	$gen .= '<table width="100%" border="0" cellspacing="0" cellpadding="2" id="'.ucfirst(strtolower($castle['name'])).'Seeds" style="margin: 5px; font: 11px Verdana, Arial, Helvetica, sans-serif;">';
	$gen .= '<tr>';
	$gen .= '<td style="background-color: #DDD"><strong>Seed Name:</strong></td>';
	$gen .= '<td style="background-color: #DDD"><strong>Seed Price:</strong></td>';
	$gen .= '</tr>';
	
	$sql2 =	'(SELECT `name`, `seed_price` FROM `etcitem`, `castle_manor_production` WHERE `seed_id` = `item_id` AND `castle_id` = '.$castle['id'].')'
				.' UNION '.
			'(SELECT `name`, `c`.`price` FROM `etcitem` e, `castle_manor_procure` c WHERE `crop_id` = `item_id` AND `castle_id` = '.$castle['id'].')'
				.' ORDER BY `name`;';
	
	$req = @mysql_query($sql2);
	$i = 1;
	while ($row = mysql_fetch_array($req, MYSQL_NUM)) {
		$gen .= '<tr>';
		$gen .= '<td style="background-color: #'.( ($i % 2) ? 'EEE' : 'DDD' ).'">'.$row[0].'</td>';
		$gen .= '<td style="background-color: #'.( ($i % 2) ? 'EEE' : 'DDD' ).'">'.$row[1].'</td>';
		$gen .= '</tr>';
		$i++;
	}
	
	
	$gen .= '</table>';
	
	
	$gen .= '</div>\';'."\n\n";
}

$handle = @fopen($filename, 'w+');
@fwrite($handle, $gen);
@fclose($handle);

?>






<?php
/*

oreninfo = '<div class="castleWrapper">
  <div class="castlePic" id="OrenPic"></div>
  <div class="castleInfo">
    <div class="castleName"><strong>Oren Castle</strong></div>
    <div><strong>Controlled by:</strong> Aur0ra </div>
    <div><strong>Tax Rate:</strong> 15%</div>
    <div><strong>Next Siege:</strong> May 24 2009 03:00PM </div>
  </div>
  
    <tr>
      <td><strong>Seed Name:</strong></td>
      <td><strong>Seed Price:</strong></td>
    </tr>
    <tr>
      <td>Seed: Dark Coda</td>
      <td>0 </td>
    </tr>
    <tr>
      <td>Alt Dark Coda Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Red Coda</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Alt Red Coda Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Blue Coda </td>
      <td>0</td>
    </tr>
    <tr>
      <td>Alt Blue
        Coda Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Chilly Cobol</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Alt Chilly Cobol
        Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Blue Cobol </td>
      <td>0</td>
    </tr>
    <tr>
      <td>Alt Blue Cobol Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Thorn Cobol </td>
      <td>500</td>
    </tr>
    <tr>
      <td>Alt Thorn Cobol Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Sea Codran</td>
      <td>500</td>
    </tr>
    <tr>
      <td>Alt Sea Codran Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Chilly Codran</td>
      <td>400</td>
    </tr>
    <tr>
      <td>Alt Chilly Codran Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Blue Codran</td>
      <td>500</td>
    </tr>
    <tr>
      <td>Alt Blue Codran Seed</td>
      <td>0</td>
    </tr>
    <tr>
      <td>Seed: Twin Codran</td>
      <td>500</td>
    </tr>
    <tr>
      <td>Alt Twin Codran Seed</td>
      <td>0</td>
    </tr>
  </table>
</div>';


*/

?>