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
if(!$cfg['rankings_enable_guilds']) throw new Exception(lang('error_47',true));

// rankings object
$Rankings = new Rankings();

// rankings menu
$Rankings->rankingsMenu();

// cache data
$rankingCache = loadCache('rankings_guilds.cache');
if(!is_array($rankingCache)) throw new Exception(lang('error_58',true));

// display
echo '<table class="table table-striped">';
	echo '<thead>';
	echo '<tr>';
		if($cfg['rankings_show_rank_number']) echo '<th class="text-center" style="width: 80px;">'.lang('rankings_txt_24',true).'</th>';
		echo '<th class="text-center">'.lang('rankings_txt_28',true).'</th>';
		echo '<th>'.lang('rankings_txt_17',true).'</th>';
		echo '<th>'.lang('rankings_txt_18',true).'</th>';
		echo '<th>'.lang('rankings_txt_19',true).'</th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	$i = 1;
	foreach($rankingCache as $row) {
		
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
			echo '<td class="text-center">'.returnGuildLogo($row[_CLMN_GUILD_LOGO_], true, '', 40).'</td>';
			echo '<td>'.guildProfile($row[_CLMN_GUILD_NAME_]).'</td>';
			echo '<td>'.playerProfile($row[_CLMN_GUILD_MASTER_]).'</td>';
			echo '<td>'.$row[_CLMN_GUILD_SCORE_].'</td>';
			echo '</tr>';
		$i++;
	}
	echo '</tbody>';
echo '</table>';