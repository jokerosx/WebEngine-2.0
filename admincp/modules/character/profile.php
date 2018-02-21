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

try {
	
	if(!check($_GET['name'])) throw new Exception('Character name not provided.');
	
	$Player = new Player();
	$Player->setPlayer($_GET['name']);
	$characterData = $Player->getPlayerInformation();
	if(!is_array($characterData)) throw new Exception('Character data could not be loaded.');
	
	$characterMasterLevelData = $Player->getPlayerMasterLevelInformation();
	
	echo '<h1 class="text-info">'.$characterData[_CLMN_CHR_NAME_].'</h1>';
	echo '<hr>';
	echo '<div class="row">';
		echo '<div class="col-sm-12 col-md-12 col-lg-6">';
		
			// general info
			echo '<div class="card">';
				echo '<div class="header">General Information</div>';
				echo '<div class="content table-responsive table-full-width">';
				
					echo '<table class="table table-hover table-striped">';
					echo '<thead>';
						echo '<tr>';
							echo '<th>Data</th>';
							echo '<th>Value</th>';
							echo '<th class="text-right">Action</th>';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
						echo '<tr>';
							echo '<td>Name</td>';
							echo '<td>'.$characterData[_CLMN_CHR_NAME_].'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Account</td>';
							echo '<td>'.$characterData[_CLMN_CHR_ACCID_].'</td>';
							echo '<td class="text-right"><a href="'.admincp_base('account/profile/username/'.$characterData[_CLMN_CHR_ACCID_]).'" rel="tooltip" title="" class="btn btn-info btn-simple btn-xs" data-original-title="Profile"><i class="fa fa-user"></i></a></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Class</td>';
							echo '<td>'.playerClassName($characterData[_CLMN_CHR_CLASS_]).'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Level</td>';
							echo '<td>'.$characterData[_CLMN_CHR_LVL_].'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Zen</td>';
							echo '<td>'.number_format($characterData[_CLMN_CHR_ZEN_]).'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Resets</td>';
							echo '<td>'.$characterData[_CLMN_CHR_RSTS_].'</td>';
							echo '<td class="text-right"></td>';
						echo '</tr>';
					echo '</tbody>';
					echo '</table>';
					
				echo '</div>';
			echo '</div>';
		
			// stats info
			echo '<div class="card">';
				echo '<div class="header">Stats Information</div>';
				echo '<div class="content table-responsive table-full-width">';
				
					echo '<table class="table table-hover table-striped">';
					echo '<thead>';
						echo '<tr>';
							echo '<th>Data</th>';
							echo '<th>Value</th>';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
						echo '<tr>';
							echo '<td>Level-up Points</td>';
							echo '<td>'.number_format($characterData[_CLMN_CHR_LVLUP_POINT_]).'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Strength</td>';
							echo '<td>'.number_format($characterData[_CLMN_CHR_STAT_STR_]).'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Agility</td>';
							echo '<td>'.number_format($characterData[_CLMN_CHR_STAT_AGI_]).'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Vitality</td>';
							echo '<td>'.number_format($characterData[_CLMN_CHR_STAT_VIT_]).'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Energy</td>';
							echo '<td>'.number_format($characterData[_CLMN_CHR_STAT_ENE_]).'</td>';
						echo '</tr>';
						echo '<tr>';
							echo '<td>Command</td>';
							echo '<td>'.number_format($characterData[_CLMN_CHR_STAT_CMD_]).'</td>';
						echo '</tr>';
					echo '</tbody>';
					echo '</table>';
					
				echo '</div>';
			echo '</div>';
			
		echo '</div>';
		
		echo '<div class="col-sm-12 col-md-12 col-lg-6">';
			
			echo '<div class="card">';
				echo '<div class="header">Master Level Information</div>';
				echo '<div class="content table-responsive table-full-width">';
					
					if(is_array($characterMasterLevelData)) {
						echo '<table class="table table-hover table-striped">';
						echo '<thead>';
							echo '<tr>';
								echo '<th>Data</th>';
								echo '<th>Value</th>';
							echo '</tr>';
						echo '</thead>';
						echo '<tbody>';
							echo '<tr>';
								echo '<td>Master Level</td>';
								echo '<td>'.$characterMasterLevelData[_CLMN_ML_LVL_].'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>Experience</td>';
								echo '<td>'.number_format($characterMasterLevelData[_CLMN_ML_EXP_]).'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>Next Exp.</td>';
								echo '<td>'.number_format($characterMasterLevelData[_CLMN_ML_NEXP_]).'</td>';
							echo '</tr>';
							echo '<tr>';
								echo '<td>Points</td>';
								echo '<td>'.$characterMasterLevelData[_CLMN_ML_POINT_].'</td>';
							echo '</tr>';
						echo '</tbody>';
						echo '</table>';
					} else {
						message('warning', 'Master level information could not be loaded.');
					}
					
				echo '</div>';
			echo '</div>';
			
			echo '<a href="'.admincp_base('character/edit/name/'.$characterData[_CLMN_CHR_NAME_]).'" class="btn btn-warning">Edit Character</a>';
		echo '</div>';
	echo '</div>';
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}