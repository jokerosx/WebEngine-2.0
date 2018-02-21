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
		
		// rankings_results
		if(!check($_POST['rankings_results'])) throw new Exception('Invalid setting value (rankings_results)');
		if(!Validator::UnsignedNumber($_POST['rankings_results'])) throw new Exception('Invalid setting value (rankings_results)');
		$setting['rankings_results'] = $_POST['rankings_results'];
		
		// rankings_show_rank_number
		if(!check($_POST['rankings_show_rank_number'])) throw new Exception('Invalid setting value (rankings_show_rank_number)');
		if(!in_array($_POST['rankings_show_rank_number'], array(0, 1))) throw new Exception('Invalid setting value (rankings_show_rank_number)');
		$setting['rankings_show_rank_number'] = $_POST['rankings_show_rank_number'];
		
		// rankings_show_rank_laurels
		if(!check($_POST['rankings_show_rank_laurels'])) throw new Exception('Invalid setting value (rankings_show_rank_laurels)');
		if(!in_array($_POST['rankings_show_rank_laurels'], array(0, 1))) throw new Exception('Invalid setting value (rankings_show_rank_laurels)');
		$setting['rankings_show_rank_laurels'] = $_POST['rankings_show_rank_laurels'];
		
		// rankings_rank_laurels_limit
		if(!check($_POST['rankings_rank_laurels_limit'])) throw new Exception('Invalid setting value (rankings_rank_laurels_limit)');
		if(!Validator::UnsignedNumber($_POST['rankings_rank_laurels_limit'])) throw new Exception('Invalid setting value (rankings_rank_laurels_limit)');
		$setting['rankings_rank_laurels_limit'] = $_POST['rankings_rank_laurels_limit'];
		
		// rankings_rank_laurels_base_size
		if(!check($_POST['rankings_rank_laurels_base_size'])) throw new Exception('Invalid setting value (rankings_rank_laurels_base_size)');
		if(!Validator::UnsignedNumber($_POST['rankings_rank_laurels_base_size'])) throw new Exception('Invalid setting value (rankings_rank_laurels_base_size)');
		$setting['rankings_rank_laurels_base_size'] = $_POST['rankings_rank_laurels_base_size'];
		
		// rankings_rank_laurels_decrease_by
		if(!check($_POST['rankings_rank_laurels_decrease_by'])) throw new Exception('Invalid setting value (rankings_rank_laurels_decrease_by)');
		if(!Validator::UnsignedNumber($_POST['rankings_rank_laurels_decrease_by'])) throw new Exception('Invalid setting value (rankings_rank_laurels_decrease_by)');
		$setting['rankings_rank_laurels_decrease_by'] = $_POST['rankings_rank_laurels_decrease_by'];
		
		// rankings_show_online_status
		if(!check($_POST['rankings_show_online_status'])) throw new Exception('Invalid setting value (rankings_show_online_status)');
		if(!in_array($_POST['rankings_show_online_status'], array(0, 1))) throw new Exception('Invalid setting value (rankings_show_online_status)');
		$setting['rankings_show_online_status'] = $_POST['rankings_show_online_status'];
		
		// rankings_show_location
		if(!check($_POST['rankings_show_location'])) throw new Exception('Invalid setting value (rankings_show_location)');
		if(!in_array($_POST['rankings_show_location'], array(0, 1))) throw new Exception('Invalid setting value (rankings_show_location)');
		$setting['rankings_show_location'] = $_POST['rankings_show_location'];
		
		// rankings_show_gens
		if(!check($_POST['rankings_show_gens'])) throw new Exception('Invalid setting value (rankings_show_gens)');
		if(!in_array($_POST['rankings_show_gens'], array(0, 1))) throw new Exception('Invalid setting value (rankings_show_gens)');
		$setting['rankings_show_gens'] = $_POST['rankings_show_gens'];
		
		// rankings_enable_level
		if(!check($_POST['rankings_enable_level'])) throw new Exception('Invalid setting value (rankings_enable_level)');
		if(!in_array($_POST['rankings_enable_level'], array(0, 1))) throw new Exception('Invalid setting value (rankings_enable_level)');
		$setting['rankings_enable_level'] = $_POST['rankings_enable_level'];
		
		// rankings_enable_resets
		if(!check($_POST['rankings_enable_resets'])) throw new Exception('Invalid setting value (rankings_enable_resets)');
		if(!in_array($_POST['rankings_enable_resets'], array(0, 1))) throw new Exception('Invalid setting value (rankings_enable_resets)');
		$setting['rankings_enable_resets'] = $_POST['rankings_enable_resets'];
		
		// rankings_enable_pk
		if(!check($_POST['rankings_enable_pk'])) throw new Exception('Invalid setting value (rankings_enable_pk)');
		if(!in_array($_POST['rankings_enable_pk'], array(0, 1))) throw new Exception('Invalid setting value (rankings_enable_pk)');
		$setting['rankings_enable_pk'] = $_POST['rankings_enable_pk'];
		
		// rankings_enable_guilds
		if(!check($_POST['rankings_enable_guilds'])) throw new Exception('Invalid setting value (rankings_enable_guilds)');
		if(!in_array($_POST['rankings_enable_guilds'], array(0, 1))) throw new Exception('Invalid setting value (rankings_enable_guilds)');
		$setting['rankings_enable_guilds'] = $_POST['rankings_enable_guilds'];
		
		// rankings_enable_gens
		if(!check($_POST['rankings_enable_gens'])) throw new Exception('Invalid setting value (rankings_enable_gens)');
		if(!in_array($_POST['rankings_enable_gens'], array(0, 1))) throw new Exception('Invalid setting value (rankings_enable_gens)');
		$setting['rankings_enable_gens'] = $_POST['rankings_enable_gens'];
		
		// rankings_enable_votes
		if(!check($_POST['rankings_enable_votes'])) throw new Exception('Invalid setting value (rankings_enable_votes)');
		if(!in_array($_POST['rankings_enable_votes'], array(0, 1))) throw new Exception('Invalid setting value (rankings_enable_votes)');
		$setting['rankings_enable_votes'] = $_POST['rankings_enable_votes'];
		
		// rankings_excluded_characters
		$setting['rankings_excluded_characters'] = $_POST['rankings_excluded_characters'];
		if(!check($_POST['rankings_excluded_characters'])) $setting['rankings_excluded_characters'] = '';
		
		// rankings_excluded_guilds
		$setting['rankings_excluded_guilds'] = $_POST['rankings_excluded_guilds'];
		if(!check($_POST['rankings_excluded_guilds'])) $setting['rankings_excluded_guilds'] = '';
		
		// rankings_sum_master_level
		if(!check($_POST['rankings_sum_master_level'])) throw new Exception('Invalid setting value (rankings_sum_master_level)');
		if(!in_array($_POST['rankings_sum_master_level'], array(0, 1))) throw new Exception('Invalid setting value (rankings_sum_master_level)');
		$setting['rankings_sum_master_level'] = $_POST['rankings_sum_master_level'];
		
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
			echo '<div class="header">Rankings Settings</div>';
			echo '<div class="content table-responsive">';
			
				echo '<form action="" method="post">';
					echo '<table class="table table-striped table-bordered table-hover" style="table-layout: fixed;">';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Results</strong>';
								echo '<p class="setting-description">Amount of results to cache and show in the the rankings.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="rankings_results" value="'.$cfg['rankings_results'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Show Rank Number</strong>';
								echo '<p class="setting-description">If enabled, rank numbers will be displayed in the rankings table.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_rank_number" value="1" '.($cfg['rankings_show_rank_number'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_rank_number" value="0" '.(!$cfg['rankings_show_rank_number'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Show Rank Laurels</strong>';
								echo '<p class="setting-description">If enabled, the top players ranks will be displayed with laurel\'s.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_rank_laurels" value="1" '.($cfg['rankings_show_rank_laurels'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_rank_laurels" value="0" '.(!$cfg['rankings_show_rank_laurels'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Laurel\'s Rank Limit</strong>';
								echo '<p class="setting-description">Amount of laurel ranks to display. The laurel images must be in your template\'s image folder.<br /><br />Laurel\'s image naming:<br />rank_<span style="color:red;">x</span>.png</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="rankings_rank_laurels_limit" value="'.$cfg['rankings_rank_laurels_limit'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Laurel\'s Base Size (px)</strong>';
								echo '<p class="setting-description">Base size in pixels of the laurel\'s image display in the rankings table.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="rankings_rank_laurels_base_size" value="'.$cfg['rankings_rank_laurels_base_size'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Laurel\'s Size Decrease By (px)</strong>';
								echo '<p class="setting-description">Amount of pixels the laurel\'s image will decrease after each rank. Set to 0 for all laurel\'s to remain the same (base) size.</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="rankings_rank_laurels_decrease_by" value="'.$cfg['rankings_rank_laurels_decrease_by'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Show Online Status</strong>';
								echo '<p class="setting-description">If enabled, the character\'s online status will be displayed.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_online_status" value="1" '.($cfg['rankings_show_online_status'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_online_status" value="0" '.(!$cfg['rankings_show_online_status'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Show Location (map)</strong>';
								echo '<p class="setting-description">If enabled, the character\'s location (map) will be displayed.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_location" value="1" '.($cfg['rankings_show_location'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_location" value="0" '.(!$cfg['rankings_show_location'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Show Gens Family</strong>';
								echo '<p class="setting-description">If enabled, the character\'s gens family will be displayed.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_gens" value="1" '.($cfg['rankings_show_gens'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_show_gens" value="0" '.(!$cfg['rankings_show_gens'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Enable Level Rankings</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_level" value="1" '.($cfg['rankings_enable_level'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_level" value="0" '.(!$cfg['rankings_enable_level'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Enable Resets Rankings</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_resets" value="1" '.($cfg['rankings_enable_resets'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_resets" value="0" '.(!$cfg['rankings_enable_resets'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Enable Killers Rankings</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_pk" value="1" '.($cfg['rankings_enable_pk'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_pk" value="0" '.(!$cfg['rankings_enable_pk'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Enable Guilds Rankings</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_guilds" value="1" '.($cfg['rankings_enable_guilds'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_guilds" value="0" '.(!$cfg['rankings_enable_guilds'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Enable Gens Rankings</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_gens" value="1" '.($cfg['rankings_enable_gens'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_gens" value="0" '.(!$cfg['rankings_enable_gens'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Enable Votes Rankings</strong>';
								echo '<p class="setting-description"></p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_votes" value="1" '.($cfg['rankings_enable_votes'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_enable_votes" value="0" '.(!$cfg['rankings_enable_votes'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Excluded Characters</strong>';
								echo '<p class="setting-description">List of excluded characters from the rankings (separated by commas).</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="rankings_excluded_characters" value="'.$cfg['rankings_excluded_characters'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Excluded Guilds</strong>';
								echo '<p class="setting-description">List of excluded guilds from the rankings (separated by commas).</p>';
							echo '</td>';
							echo '<td>';
								echo '<input type="text" class="form-control" name="rankings_excluded_guilds" value="'.$cfg['rankings_excluded_guilds'].'">';
							echo '</td>';
						echo '</tr>';
						
						echo '<tr>';
							echo '<td>';
								echo '<strong>Sum Regular Level with Master Level</strong>';
								echo '<p class="setting-description">If enabled, the character level will be displayed as the sum of the regular level plus the master level.</p>';
							echo '</td>';
							echo '<td>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_sum_master_level" value="1" '.($cfg['rankings_sum_master_level'] ? 'checked' : null).'>';
										echo 'Enabled';
									echo '</label>';
								echo '</div>';
								echo '<div class="radio">';
									echo '<label>';
										echo '<input type="radio" name="rankings_sum_master_level" value="0" '.(!$cfg['rankings_sum_master_level'] ? 'checked' : null).'>';
										echo 'Disabled';
									echo '</label>';
								echo '</div>';
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