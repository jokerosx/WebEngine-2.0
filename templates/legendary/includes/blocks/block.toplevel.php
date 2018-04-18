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

// Rankings block (TOP LEVEL)
$levelRankingsCache = loadCache('rankings_level.cache');
if(is_array($levelRankingsCache)) {
	echo '<div class="panel panel-sidebar">';
		echo '<div class="panel-heading">';
			echo '<h3 class="panel-title">'.lang('rankings_txt_1').' <a href="'.Handler::websiteLink('rankings/level').'" class="btn btn-primary btn-xs pull-right" style="text-align:center;width:22px;">+</a></h3>';
		echo '</div>';
		echo '<div class="panel-body">';
			echo '<table class="table">';
				echo '<tr>';
					echo '<th></th>';
					echo '<th>'.lang('rankings_txt_10').'</th>';
					echo '<th>'.lang('rankings_txt_12').'</th>';
				echo '</tr>';
				foreach($levelRankingsCache as $k => $row) {
					if($k > 2) break;
					echo '<tr>';
						echo '<td>'.returnPlayerAvatar($row[_CLMN_CHR_CLASS_], true, true, 'rounded-image-corners', '25px', '25px').'</td>';
						echo '<td>'.playerProfile($row[_CLMN_CHR_NAME_]).'</td>';
						echo '<td>'.$row['playerLevel'].'</td>';
					echo '</tr>';
				}
			echo '</table>';
		echo '</div>';
	echo '</div>';
}
