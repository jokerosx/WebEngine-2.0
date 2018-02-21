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
	
	$playerClassData = custom('character_class');
	
	echo '<h1 class="text-info">'.$characterData[_CLMN_CHR_NAME_].'</h1>';
	echo '<hr>';
	
	if(check($_POST['submit_edit'])) {
		try {
			
			// filters
			if(!check($_POST[_CLMN_CHR_LVL_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_CLASS_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_ZEN_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_RSTS_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_LVLUP_POINT_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_STAT_STR_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_STAT_AGI_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_STAT_VIT_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_STAT_ENE_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_CHR_STAT_CMD_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_ML_LVL_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_ML_EXP_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_ML_NEXP_])) throw new Exception('Please complete all required fields');
			if(!check($_POST[_CLMN_ML_POINT_])) throw new Exception('Please complete all required fields');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_LVL_])) throw new Exception('The character\'s level must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_CLASS_])) throw new Exception('The character\'s class must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_ZEN_])) throw new Exception('The character\'s zen must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_RSTS_])) throw new Exception('The character\'s resets must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_LVLUP_POINT_])) throw new Exception('The character\'s level-up points must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_STAT_STR_])) throw new Exception('The character\'s strength must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_STAT_AGI_])) throw new Exception('The character\'s agility must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_STAT_VIT_])) throw new Exception('The character\'s vitality must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_STAT_ENE_])) throw new Exception('The character\'s energy must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_CHR_STAT_CMD_])) throw new Exception('The character\'s command must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_ML_LVL_])) throw new Exception('The character\'s master level must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_ML_EXP_])) throw new Exception('The character\'s master level experience must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_ML_NEXP_])) throw new Exception('The character\'s master level next experience must be numeric.');
			if(!Validator::UnsignedNumber($_POST[_CLMN_ML_POINT_])) throw new Exception('The character\'s xxxxx master level points be numeric.');
			
			
			// object
			$PlayerEdit = new Player();
			$PlayerEdit->setPlayer($characterData[_CLMN_CHR_NAME_]);
			
			// set edits
			$PlayerEdit->_editValue(_CLMN_CHR_LVL_, $_POST[_CLMN_CHR_LVL_]);
			$PlayerEdit->_editValue(_CLMN_CHR_CLASS_, $_POST[_CLMN_CHR_CLASS_]);
			$PlayerEdit->_editValue(_CLMN_CHR_ZEN_, $_POST[_CLMN_CHR_ZEN_]);
			$PlayerEdit->_editValue(_CLMN_CHR_RSTS_, $_POST[_CLMN_CHR_RSTS_]);
			$PlayerEdit->_editValue(_CLMN_CHR_LVLUP_POINT_, $_POST[_CLMN_CHR_LVLUP_POINT_]);
			$PlayerEdit->_editValue(_CLMN_CHR_STAT_STR_, $_POST[_CLMN_CHR_STAT_STR_]);
			$PlayerEdit->_editValue(_CLMN_CHR_STAT_AGI_, $_POST[_CLMN_CHR_STAT_AGI_]);
			$PlayerEdit->_editValue(_CLMN_CHR_STAT_VIT_, $_POST[_CLMN_CHR_STAT_VIT_]);
			$PlayerEdit->_editValue(_CLMN_CHR_STAT_ENE_, $_POST[_CLMN_CHR_STAT_ENE_]);
			$PlayerEdit->_editValue(_CLMN_CHR_STAT_CMD_, $_POST[_CLMN_CHR_STAT_CMD_]);
			
			// save edits
			if(!$PlayerEdit->_saveEdits()) throw new Exception('There was an error saving the changes.');
			
			if(is_array($characterMasterLevelData)) {
				// master level object
				$PlayerEditML = new Player();
				$PlayerEditML->setPlayer($characterData[_CLMN_CHR_NAME_]);
				$PlayerEditML->_setEditTable(_TBL_MASTERLVL_);
				$PlayerEditML->_setEditNameColumn(_CLMN_ML_NAME_);
				
				// master level set edits
				$PlayerEditML->_editValue(_CLMN_ML_LVL_, $_POST[_CLMN_ML_LVL_]);
				$PlayerEditML->_editValue(_CLMN_ML_EXP_, $_POST[_CLMN_ML_EXP_]);
				$PlayerEditML->_editValue(_CLMN_ML_NEXP_, $_POST[_CLMN_ML_NEXP_]);
				$PlayerEditML->_editValue(_CLMN_ML_POINT_, $_POST[_CLMN_ML_POINT_]);
				
				// master level save edits
				if(!$PlayerEditML->_saveEdits()) throw new Exception('There was an error saving the master level changes.');
			}
			
			redirect('character/profile/name/'.$characterData[_CLMN_CHR_NAME_]);
			
		} catch(Exception $ex) {
			message('error', $ex->getMessage());
		}
	}
	
	echo '<form action="" method="post">';
		echo '<div class="row">';
			// general
			echo '<div class="col-sm-6 col-md-6 col-lg-6">';
			
				echo '<div class="card">';
					echo '<div class="header">Edit General Information</div>';
					echo '<div class="content table-responsive">';
						
						echo '<div class="row">';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_1">Level</label>';
									echo '<input type="text" class="form-control" id="input_1" name="'._CLMN_CHR_LVL_.'" value="'.$characterData[_CLMN_CHR_LVL_].'">';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_2">Class</label>';
									echo '<select class="form-control" id="input_2" name="'._CLMN_CHR_CLASS_.'">';
										foreach($playerClassData as $classCode => $classData) {
											if($characterData[_CLMN_CHR_CLASS_] == $classCode) {
												echo '<option value="'.$classCode.'" selected>'.$classData[0].' ('.$classCode.')</option>';
											} else {
												echo '<option value="'.$classCode.'">'.$classData[0].' ('.$classCode.')</option>';
											}
										}
									echo '</select>';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
						echo '<div class="row">';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_3">Zen</label>';
									echo '<input type="text" class="form-control" id="input_3" name="'._CLMN_CHR_ZEN_.'" value="'.$characterData[_CLMN_CHR_ZEN_].'">';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_4">Resets</label>';
									echo '<input type="text" class="form-control" id="input_4" name="'._CLMN_CHR_RSTS_.'" value="'.$characterData[_CLMN_CHR_RSTS_].'">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
						echo '<div class="row">';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_14">Level-up Points</label>';
									echo '<input type="text" class="form-control" id="input_14" name="'._CLMN_CHR_LVLUP_POINT_.'" value="'.$characterData[_CLMN_CHR_LVLUP_POINT_].'">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
					echo '</div>';
				echo '</div>';
			
			echo '</div>';
			
			//master level
			echo '<div class="col-sm-6 col-md-6 col-lg-6">';
			
				echo '<div class="card">';
					echo '<div class="header">Edit Master Level</div>';
					echo '<div class="content table-responsive">';
						
						if(is_array($characterMasterLevelData)) {
							echo '<div class="row">';
								echo '<div class="col-sm-6 col-md-6 col-lg-6">';
									echo '<div class="form-group">';
										echo '<label for="input_5">Master Level</label>';
										echo '<input type="text" class="form-control" id="input_5" name="'._CLMN_ML_LVL_.'" value="'.$characterMasterLevelData[_CLMN_ML_LVL_].'">';
									echo '</div>';
								echo '</div>';
								echo '<div class="col-sm-6 col-md-6 col-lg-6">';
									echo '<div class="form-group">';
										echo '<label for="input_6">Experience</label>';
										echo '<input type="text" class="form-control" id="input_6" name="'._CLMN_ML_EXP_.'" value="'.$characterMasterLevelData[_CLMN_ML_EXP_].'">';
									echo '</div>';
								echo '</div>';
							echo '</div>';
							
							echo '<div class="row">';
								echo '<div class="col-sm-6 col-md-6 col-lg-6">';
									echo '<div class="form-group">';
										echo '<label for="input_7">Next Exp.</label>';
										echo '<input type="text" class="form-control" id="input_7" name="'._CLMN_ML_NEXP_.'" value="'.$characterMasterLevelData[_CLMN_ML_NEXP_].'">';
									echo '</div>';
								echo '</div>';
								echo '<div class="col-sm-6 col-md-6 col-lg-6">';
									echo '<div class="form-group">';
										echo '<label for="input_8">Points</label>';
										echo '<input type="text" class="form-control" id="input_8" name="'._CLMN_ML_POINT_.'" value="'.$characterMasterLevelData[_CLMN_ML_POINT_].'">';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						} else {
							message('warning', 'Master level information could not be loaded.');
						}
						
					echo '</div>';
				echo '</div>';
			
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			// stats
			echo '<div class="col-sm-6 col-md-6 col-lg-6">';
			
				echo '<div class="card">';
					echo '<div class="header">Edit Stats</div>';
					echo '<div class="content table-responsive">';
						
						echo '<div class="row">';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_9">Strength</label>';
									echo '<input type="text" class="form-control" id="input_9" name="'._CLMN_CHR_STAT_STR_.'" value="'.$characterData[_CLMN_CHR_STAT_STR_].'">';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_10">Agility</label>';
									echo '<input type="text" class="form-control" id="input_10" name="'._CLMN_CHR_STAT_AGI_.'" value="'.$characterData[_CLMN_CHR_STAT_AGI_].'">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
						echo '<div class="row">';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_11">Vitality</label>';
									echo '<input type="text" class="form-control" id="input_11" name="'._CLMN_CHR_STAT_VIT_.'" value="'.$characterData[_CLMN_CHR_STAT_VIT_].'">';
								echo '</div>';
							echo '</div>';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_12">Energy</label>';
									echo '<input type="text" class="form-control" id="input_12" name="'._CLMN_CHR_STAT_ENE_.'" value="'.$characterData[_CLMN_CHR_STAT_ENE_].'">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
						echo '<div class="row">';
							echo '<div class="col-sm-6 col-md-6 col-lg-6">';
								echo '<div class="form-group">';
									echo '<label for="input_13">Command</label>';
									echo '<input type="text" class="form-control" id="input_13" name="'._CLMN_CHR_STAT_CMD_.'" value="'.$characterData[_CLMN_CHR_STAT_CMD_].'">';
								echo '</div>';
							echo '</div>';
						echo '</div>';
						
					echo '</div>';
				echo '</div>';
				
			echo '</div>';
			
		echo '</div>';
		
		echo '<button type="submit" name="submit_edit" value="ok" class="btn btn-primary">Save Changes</button> ';
		echo '<a href="'.admincp_base('character/profile/name/'.$characterData[_CLMN_CHR_NAME_]).'" class="btn btn-danger">Cancel</a>';
	
	echo '</form>';
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}