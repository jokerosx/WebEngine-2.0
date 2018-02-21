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
$cfg = loadModuleConfig('character.addstats');
if(!is_array($cfg)) throw new Exception(lang('error_66',true));

// base stats
$baseStats = custom('character_class');
if(!is_array($baseStats)) throw new Exception(lang('error_229'));

// player information
$Player = new Player();
$Player->setUsername($_SESSION['username']);
$accountPlayers = $Player->getAccountPlayerList();
if(!is_array($accountPlayers)) throw new Exception(lang('error_46',true));

// form submit
if(check($_POST['submit'])) {
	try {
		$PlayerAddStats = new PlayerAddStats();
		$PlayerAddStats->setUsername($_SESSION['username']);
		$PlayerAddStats->setPlayer($_POST['player']);
		
		if(check($_POST['add_str'])) $PlayerAddStats->setStrength($_POST['add_str']);
		if(check($_POST['add_agi'])) $PlayerAddStats->setAgility($_POST['add_agi']);
		if(check($_POST['add_vit'])) $PlayerAddStats->setVitality($_POST['add_vit']);
		if(check($_POST['add_ene'])) $PlayerAddStats->setEnergy($_POST['add_ene']);
		if(check($_POST['add_com'])) $PlayerAddStats->setCommand($_POST['add_com']);
		
		$PlayerAddStats->addstats();
		
		message('success', lang('success_17',true));
	} catch(Exception $ex) {
		message('error', $ex->getMessage());
	}
}

// form
foreach($accountPlayers as $playerName) {
	if(!check($playerName)) continue;
	$Player->setPlayer($playerName);
	$playerInformation = $Player->getPlayerInformation();
	if(!is_array($baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats'])) continue;
	
	echo '<div class="panel panel-addstats">';
		echo '<div class="panel-body">';
			echo '<div class="col-xs-3 nopadding text-center character-avatar">';
				echo returnPlayerAvatar($playerInformation[_CLMN_CHR_CLASS_]);
			echo '</div>';
			echo '<div class="col-xs-9 nopadding">';
				echo '<div class="col-xs-12 nopadding character-name">';
					echo playerProfile($playerInformation[_CLMN_CHR_NAME_]);
				echo '</div>';
				echo '<div class="col-sm-10">';
					echo '<form class="form-horizontal" action="" method="post">';
						
						echo '<input type="hidden" name="player" value="'.$playerInformation[_CLMN_CHR_NAME_].'"/>';
						
						echo '<div class="form-group">';
							echo '<label for="inputStat" class="col-sm-4 control-label"></label>';
							echo '<div class="col-sm-8">';
								echo lang('addstats_txt_2', array(number_format($playerInformation[_CLMN_CHR_LVLUP_POINT_])));
							echo '</div>';
						echo '</div>';
						echo '<div class="form-group">';
							echo '<label for="inputStat1" class="col-sm-4 control-label">'.lang('addstats_txt_3',true).'</label>';
							echo '<div class="col-sm-8">';
								echo '<div class="input-group">';
									echo '<div class="input-group-addon">'.number_format($playerInformation[_CLMN_CHR_STAT_STR_]).' +</div>';
									echo '<input type="number" class="form-control" id="inputStat1" min="1" step="1" max="'.$cfg['max_stats'].'" name="add_str" placeholder="0">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						echo '<div class="form-group">';
							echo '<label for="inputStat2" class="col-sm-4 control-label">'.lang('addstats_txt_4',true).'</label>';
							echo '<div class="col-sm-8">';
								echo '<div class="input-group">';
									echo '<div class="input-group-addon">'.number_format($playerInformation[_CLMN_CHR_STAT_AGI_]).' +</div>';
									echo '<input type="number" class="form-control" id="inputStat2" min="1" step="1" max="'.$cfg['max_stats'].'" name="add_agi" placeholder="0">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						echo '<div class="form-group">';
							echo '<label for="inputStat3" class="col-sm-4 control-label">'.lang('addstats_txt_5',true).'</label>';
							echo '<div class="col-sm-8">';
								echo '<div class="input-group">';
									echo '<div class="input-group-addon">'.number_format($playerInformation[_CLMN_CHR_STAT_VIT_]).' +</div>';
									echo '<input type="number" class="form-control" id="inputStat3" min="1" step="1" max="'.$cfg['max_stats'].'" name="add_vit" placeholder="0">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						echo '<div class="form-group">';
							echo '<label for="inputStat4" class="col-sm-4 control-label">'.lang('addstats_txt_6',true).'</label>';
							echo '<div class="col-sm-8">';
								echo '<div class="input-group">';
									echo '<div class="input-group-addon">'.number_format($playerInformation[_CLMN_CHR_STAT_ENE_]).' +</div>';
									echo '<input type="number" class="form-control" id="inputStat4" min="1" step="1" max="'.$cfg['max_stats'].'" name="add_ene" placeholder="0">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
						if($baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['cmd'] >= 1) {
							echo '<div class="form-group">';
								echo '<label for="inputStat5" class="col-sm-4 control-label">'.lang('addstats_txt_7',true).'</label>';
								echo '<div class="col-sm-8">';
									echo '<div class="input-group">';
										echo '<div class="input-group-addon">'.number_format($playerInformation[_CLMN_CHR_STAT_CMD_]).' +</div>';
										echo '<input type="text" class="form-control" id="inputStat5" min="1" step="1" max="'.$cfg['max_stats'].'" name="add_com" placeholder="0">';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
						
						echo '<div class="form-group">';
							echo '<div class="col-sm-12 text-right">';
								echo '<button name="submit" value="submit" class="btn btn-primary">'.lang('addstats_txt_8',true).'</button>';
							echo '</div>';
						echo '</div>';
					echo '</form>';
				echo '</div>';
				
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

// requirements
echo '<ul class="account-character-requirements">';
	if($cfg['required_level'] >= 1) echo '<li>'.lang('addstats_txt_10', array(number_format($cfg['required_level']))).'</li>';
	if($cfg['required_zen'] >= 1) echo '<li>'.lang('addstats_txt_9', array(number_format($cfg['required_zen']))).'</li>';
echo '</ul>';