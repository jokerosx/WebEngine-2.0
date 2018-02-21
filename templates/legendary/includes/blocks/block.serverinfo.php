<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 2.0.0
 * @author Lautaro Angelico <https://lautaroangelico.com/>
 * @copyright (c) 2013-2018 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * https://opensource.org/licenses/MIT
 */

// Server info block
$serverInfo = loadCache('server_info.cache');
if(is_array($serverInfo)) {
	echo '<div class="panel panel-sidebar">';
		echo '<div class="panel-heading">';
			echo '<h3 class="panel-title">'.lang('sidebar_srvinfo_txt_1').'</h3>';
		echo '</div>';
		echo '<div class="panel-body">';
			echo '<table class="table">';
				
				echo '<tr><td>Version:</td><td>SXIII</td></tr>';
				echo '<tr><td>Experience:</td><td>30x</td></tr>';
				echo '<tr><td>Drop:</td><td>40%</td></tr>';
				
				echo '<tr><td>'.lang('sidebar_srvinfo_txt_2').'</td><td>'.number_format($serverInfo['total_accounts']).'</td></tr>';
				echo '<tr><td>'.lang('sidebar_srvinfo_txt_3').'</td><td>'.number_format($serverInfo['total_players']).'</td></tr>';
				echo '<tr><td>'.lang('sidebar_srvinfo_txt_4').'</td><td>'.number_format($serverInfo['total_guilds']).'</td></tr>';
				echo '<tr><td>'.lang('sidebar_srvinfo_txt_5').'</td><td style="color:#00aa00;font-weight:bold;">'.number_format($serverInfo['total_online']).'</td></tr>';
			echo '</table>';
		echo '</div>';
	echo '</div>';
}