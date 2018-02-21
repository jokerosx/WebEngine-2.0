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

// module configs
$cfg = loadModuleConfig('rankings');
if(!is_array($cfg)) throw new Exception(lang('error_66',true));

// module status
if(!$cfg['rankings_enable_level']) throw new Exception(lang('error_47',true));

// rankings object
$Rankings = new Rankings();

// rankings menu
$Rankings->rankingsMenu();

// cache data
$rankingCache = loadCache('rankings_level.cache');
if(!is_array($rankingCache)) throw new Exception(lang('error_58',true));

// online players cache
if($cfg['rankings_show_online_status']) {
	$onlinePlayers = loadCache('online_players.cache');
}

// display
echo '<table class="table table-striped">';
	echo '<thead>';
	echo '<tr>';
		if($cfg['rankings_show_rank_number']) echo '<th class="text-center" style="width: 80px;">'.lang('rankings_txt_24',true).'</th>';
		echo '<th class="text-center">'.lang('rankings_txt_11',true).'</th>';
		echo '<th>'.lang('rankings_txt_10',true).'</th>';
		echo '<th>'.lang('rankings_txt_12',true).'</th>';
		if($cfg['rankings_show_location']) echo '<th>'.lang('rankings_txt_21',true).'</th>';
		echo '<th class="text-center">'.lang('rankings_txt_29',true).'</th>';
		if($cfg['rankings_show_online_status']) echo '<th class="text-center">'.lang('rankings_txt_33',true).'</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$i = 1;
	foreach($rankingCache as $row) {
		
		$level = $cfg['rankings_sum_master_level'] ? $row['playerLevel'] : $row[_CLMN_CHR_LVL_];
		
		if($cfg['rankings_show_online_status']) {
			$onlineStatus = in_array($row[_CLMN_CHR_NAME_], $onlinePlayers) ? '<span class="status-online"></span>' : '<span class="status-offline"></span>';
		}
		
		echo '<tr>';
			if($cfg['rankings_show_rank_number']) {
				if($cfg['rankings_show_rank_laurels']) {
					if($i <= $cfg['rankings_rank_laurels_limit']) {
						$size = $cfg['rankings_rank_laurels_base_size']-($cfg['rankings_rank_laurels_decrease_by']*$i);
						echo '<td class="text-center"><img src="'.Handler::templateIMG().'rank_'.$i.'.png" width="'.$size.'px" height="'.$size.'px"/></td>';
					} else {
						echo '<td class="text-center">'.$i.'</td>';
					}
				} else {
					echo '<td class="text-center">'.$i.'</td>';
				}
			}
			echo '<td class="text-center">'.returnPlayerAvatar($row[_CLMN_CHR_CLASS_], true, true, 'rankings-player-class-img rounded-image-corners').'</td>';
			echo '<td>'.playerProfile($row[_CLMN_CHR_NAME_]).'</td>';
			echo '<td>'.$level.'</td>';
			if($cfg['rankings_show_location']) echo '<td>'.returnMapName($row[_CLMN_CHR_MAP_]).'</td>';
			echo '<td class="text-center">'.returnGensIcon($row[_gens][_CLMN_GENS_TYPE_], true, true, 'rankings-player-gens-img').'</td>';
			if($cfg['rankings_show_online_status']) echo '<td class="text-center">'.$onlineStatus.'</td>';
			echo '</tr>';
		$i++;
	}
	echo '</tbody>';
echo '</table>';