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

$configurationFile = $_GET['id'];

if(check($_POST['settings_submit'])) {
	try {
		
		// Required Level
		if(!check($_POST['required_level'])) throw new Exception('Invalid setting value (required_level)');
		if(!Validator::UnsignedNumber($_POST['required_level'])) throw new Exception('Invalid setting value (required_level)');
		$setting['required_level'] = $_POST['required_level'];
		
		// Required Zen
		if(!check($_POST['required_zen'])) throw new Exception('Invalid setting value (required_zen)');
		if(!Validator::UnsignedNumber($_POST['required_zen'])) throw new Exception('Invalid setting value (required_zen)');
		$setting['required_zen'] = $_POST['required_zen'];
		
		// Reset Stats
		if(!check($_POST['reset_stats'])) throw new Exception('Invalid setting value (reset_stats)');
		if(!in_array($_POST['reset_stats'], array(0, 1))) throw new Exception('Invalid setting value (reset_stats)');
		$setting['reset_stats'] = $_POST['reset_stats'];
		
		// Reset Level-up Points
		if(!check($_POST['reset_leveluppoints'])) throw new Exception('Invalid setting value (reset_leveluppoints)');
		if(!in_array($_POST['reset_leveluppoints'], array(0, 1))) throw new Exception('Invalid setting value (reset_leveluppoints)');
		$setting['reset_leveluppoints'] = $_POST['reset_leveluppoints'];
		
		// Level-up Points Reward
		if(!check($_POST['reward_leveluppoints'])) throw new Exception('Invalid setting value (reward_leveluppoints)');
		if(!Validator::UnsignedNumber($_POST['reward_leveluppoints'])) throw new Exception('Invalid setting value (reward_leveluppoints)');
		$setting['reward_leveluppoints'] = $_POST['reward_leveluppoints'];
		
		// Multiply Level-up Points Reward
		if(!check($_POST['multiply_reward_leveluppoints'])) throw new Exception('Invalid setting value (multiply_reward_leveluppoints)');
		if(!in_array($_POST['multiply_reward_leveluppoints'], array(0, 1))) throw new Exception('Invalid setting value (multiply_reward_leveluppoints)');
		$setting['multiply_reward_leveluppoints'] = $_POST['multiply_reward_leveluppoints'];
		
		// Reset Limit
		if(!check($_POST['reset_limit'])) throw new Exception('Invalid setting value (reset_limit)');
		if(!Validator::UnsignedNumber($_POST['reset_limit'])) throw new Exception('Invalid setting value (reset_limit)');
		$setting['reset_limit'] = $_POST['reset_limit'];
		
		// Update Configurations
		if(!updateModuleConfig($configurationFile, $setting)) throw new Exception('There was an error updating the configuration file.');
		
		message('success', 'Settings successfully saved!');
	} catch(Exception $ex) {
		message('error', $ex->getMessage());
	}
}

$cfg = loadModuleConfig($configurationFile);
if(!is_array($cfg)) throw new Exception('Could not load configuration file.');

echo '<div class="row">';
	echo '<div class="col-sm-12">';
		echo '<div class="card">';
			echo '<div class="header">Character Reset Settings</div>';
			echo '<div class="content table-responsive">';
			
				echo '<form action="" method="post">';
					echo '<table class="table table-striped table-bordered table-hover" style="table-layout: fixed;">';
					
						echo '<tr>';
							echo '<td>';
								echo '<strong>Required Level</strong>';
								echo '<p class="setting-description">Level required to perform the reset.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="required_level" value="'.$cfg['required_level'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Required Zen</strong>';
								echo '<p class="setting-description">Amount of zen needed to perform the reset.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="required_zen" value="'.$cfg['required_zen'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Reset Stats</strong>';
								echo '<p class="setting-description">If enabled, the character stats will be reset to it\'s base stats.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="reset_stats" value="1" '.($cfg['reset_stats'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="reset_stats" value="0" '.(!$cfg['reset_stats'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Reset Level-up Points</strong>';
								echo '<p class="setting-description">If enabled, the character\'s level-up points will be reset.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="reset_leveluppoints" value="1" '.($cfg['reset_leveluppoints'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="reset_leveluppoints" value="0" '.(!$cfg['reset_leveluppoints'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Level-up Points Reward</strong>';
								echo '<p class="setting-description">Amount of level-up points the character will receive.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="reward_leveluppoints" value="'.$cfg['reward_leveluppoints'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Multiply Level-up Points Reward</strong>';
								echo '<p class="setting-description">If enabled, the amount of level-up points rewarded in the above setting will be multiplied by the amount of resets.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="multiply_reward_leveluppoints" value="1" '.($cfg['multiply_reward_leveluppoints'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="multiply_reward_leveluppoints" value="0" '.(!$cfg['multiply_reward_leveluppoints'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Resets Limit</strong>';
								echo '<p class="setting-description">Maximum amount of resets a character can have. Set to 0 for unlimited resets.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="reset_limit" value="'.$cfg['reset_limit'].'">';
							echo '</td>';
						echo '</tr>';
						
					echo '</table>';
					echo '<br />';
					echo '<button type="submit" name="settings_submit" value="ok" class="btn btn-primary">Save Settings</button> ';
					echo '<a href="'.admincp_base('modulemanager/list').'" class="btn btn-danger">Cancel</a>';
				echo '</form>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
echo '</div>';