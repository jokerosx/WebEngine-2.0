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
$cfg = loadModuleConfig('character.unstick');
if(!is_array($cfg)) throw new Exception(lang('error_66',true));

// player information
$Player = new Player();
$Player->setUsername($_SESSION['username']);
$accountPlayers = $Player->getAccountPlayerList();
if(!is_array($accountPlayers)) throw new Exception(lang('error_46',true));

// form submit
if(check($_GET['player'])) {
	try {
		$playerUnstick = new PlayerUnstick();
		$playerUnstick->setUsername($_SESSION['username']);
		$playerUnstick->setPlayer($_GET['player']);
		$playerUnstick->unstick();
		
		message('success', lang('success_11',true));
	} catch(Exception $ex) {
		message('error', $ex->getMessage());
	}
}

// form
echo '<table class="table table-striped account-character-table">';
	echo '<thead>';
	echo '<tr>';
		echo '<th></th>';
		echo '<th>'.lang('unstickcharacter_txt_1',true).'</th>';
		echo '<th>'.lang('unstickcharacter_txt_2',true).'</th>';
		echo '<th>'.lang('unstickcharacter_txt_5',true).'</th>';
		echo '<th></th>';
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	foreach($accountPlayers as $playerName) {
		if(!check($playerName)) continue;
		$Player->setPlayer($playerName);
		$playerInformation = $Player->getPlayerInformation();
		
		echo '<tr>';
			echo '<td class="text-center">'.returnPlayerAvatar($playerInformation[_CLMN_CHR_CLASS_], true, true, 'rounded-image-corners').'</td>';
			echo '<td>'.playerProfile($playerInformation[_CLMN_CHR_NAME_]).'</td>';
			echo '<td>'.number_format($playerInformation[_CLMN_CHR_ZEN_]).'</td>';
			echo '<td>'.returnMapName($playerInformation[_CLMN_CHR_MAP_]).'</td>';
			echo '<td class="text-right"><a href="'.Handler::websiteLink('account/character/unstick/player/'.$playerInformation[_CLMN_CHR_NAME_]).'" class="btn btn-primary">'.lang('unstickcharacter_txt_3',true).'</a></td>';
		echo '</tr>';
	}
	echo '</tbody>';
echo '</table>';

// requirements
echo '<ul class="account-character-requirements">';
	if($cfg['required_level'] >= 1) echo '<li>'.lang('unstickcharacter_txt_6', array(number_format($cfg['required_level']))).'</li>';
	if($cfg['required_zen'] >= 1) echo '<li>'.lang('unstickcharacter_txt_4', array(number_format($cfg['required_zen']))).'</li>';
echo '</ul>';