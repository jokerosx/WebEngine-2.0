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

class PlayerResetStats extends Player {
	
	private $_configurationFile = 'character.resetstats';
	
	protected $_requiredLevel = 0;
	protected $_requiredZen = 0;
	
	function __construct() {
		parent::__construct();
		
		$cfg = loadModuleConfig($this->_configurationFile);
		if(!is_array($cfg)) throw new Exception(lang('error_66'));
		
		$this->_requiredLevel = $cfg['required_level'];
		$this->_requiredZen = $cfg['required_zen'];
	}
	
	public function resetstats() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		// get player information
		$playerInformation = $this->getPlayerInformation();
		if(!is_array($playerInformation)) throw new Exception(lang('error_67'));
		
		// check if player belongs to account
		if(!$this->belongsToAccount()) throw new Exception(lang('error_35'));
		
		// edits begin
		
		// level requirement
		if($this->_requiredLevel >= 1) {
			if($playerInformation[_CLMN_CHR_LVL_] < $this->_requiredLevel) throw new Exception(lang('error_33'));
		}
		
		// zen requirement
		if($this->_requiredZen >= 1) {
			if($playerInformation[_CLMN_CHR_ZEN_] < $this->_requiredZen) throw new Exception(lang('error_34'));
			$this->_editValue(_CLMN_CHR_ZEN_, ($playerInformation[_CLMN_CHR_ZEN_]-$this->_requiredZen));
		}
		
		// base stats
		$baseStats = custom('character_class');
		if(!is_array($baseStats)) throw new Exception(lang('error_229'));
		if(!is_array($baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats'])) throw new Exception(lang('error_229'));
		
		// reset stats
		$this->_editValue(_CLMN_CHR_STAT_STR_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['str']);
		$this->_editValue(_CLMN_CHR_STAT_AGI_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['agi']);
		$this->_editValue(_CLMN_CHR_STAT_VIT_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['vit']);
		$this->_editValue(_CLMN_CHR_STAT_ENE_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['ene']);
		$this->_editValue(_CLMN_CHR_STAT_CMD_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['cmd']);
		
		// add level up points
		$totalPoints = array_sum([$playerInformation[_CLMN_CHR_STAT_STR_], $playerInformation[_CLMN_CHR_STAT_AGI_], $playerInformation[_CLMN_CHR_STAT_VIT_], $playerInformation[_CLMN_CHR_STAT_ENE_], $playerInformation[_CLMN_CHR_STAT_CMD_], $playerInformation[_CLMN_CHR_LVLUP_POINT_]]);
		$totalBasePoints = array_sum($baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']);
		$newLevelUpPoints = $totalPoints-$totalBasePoints;
		if($totalPoints < $totalBasePoints) throw new Exception(lang('error_71'));
		if($newLevelUpPoints < 1) throw new Exception(lang('error_71'));
		$this->_editValue(_CLMN_CHR_LVLUP_POINT_, $newLevelUpPoints);
		
		// save
		if(!$this->_saveEdits()) throw new Exception(lang('error_71'));
	}
	
}