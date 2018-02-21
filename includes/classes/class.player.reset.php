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

class PlayerReset extends Player {
	
	private $_configurationFile = 'character.reset';
	protected $_defaultLevel = 1;
	protected $_rebirthIncrement = 1;
	
	protected $_requiredLevel = 400;
	protected $_requiredZen = 0;
	protected $_resetStats = false;
	protected $_resetLevelUpPoints = false;
	protected $_rewardLevelUpPoints = 0;
	protected $_multiplyRewardLevelUpPoints = false;
	protected $_resetLimit = 0;
	
	function __construct() {
		parent::__construct();
		
		$cfg = loadModuleConfig($this->_configurationFile);
		if(!is_array($cfg)) throw new Exception(lang('error_66'));
		
		$this->_requiredLevel = $cfg['required_level'];
		$this->_requiredZen = $cfg['required_zen'];
		$this->_resetStats = $cfg['reset_stats'];
		$this->_resetLevelUpPoints = $cfg['reset_leveluppoints'];
		$this->_rewardLevelUpPoints = $cfg['reward_leveluppoints'];
		$this->_multiplyRewardLevelUpPoints = $cfg['multiply_reward_leveluppoints'];
		$this->_resetLimit = $cfg['reset_limit'];
		
	}
	
	public function rebirth() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		// get player information
		$playerInformation = $this->getPlayerInformation();
		if(!is_array($playerInformation)) throw new Exception(lang('error_67'));
		
		// check if player belongs to account
		if(!$this->belongsToAccount()) throw new Exception(lang('error_32'));
		
		// edits begin
		$currentReset = $playerInformation[_CLMN_CHR_RSTS_];
		$newReset = $currentReset+$this->_rebirthIncrement;
		
		// reset limit
		if($this->_resetLimit >= 1) {
			if($currentReset >= $this->_resetLimit) throw new Exception(lang('error_230'));
		}
		
		// level requirement
		if($this->_requiredLevel >= 1) {
			if($playerInformation[_CLMN_CHR_LVL_] < $this->_requiredLevel) throw new Exception(lang('error_33'));
			$this->_editValue(_CLMN_CHR_LVL_, $this->_defaultLevel);
		}
		
		// zen requirement
		if($this->_requiredZen >= 1) {
			if($playerInformation[_CLMN_CHR_ZEN_] < $this->_requiredZen) throw new Exception(lang('error_34'));
			$this->_editValue(_CLMN_CHR_ZEN_, ($playerInformation[_CLMN_CHR_ZEN_]-$this->_requiredZen));
		}
		
		// reset stats
		if($this->_resetStats) {
			$baseStats = custom('character_class');
			if(!is_array($baseStats)) throw new Exception(lang('error_229'));
			if(!is_array($baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats'])) throw new Exception(lang('error_229'));
			
			$this->_editValue(_CLMN_CHR_STAT_STR_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['str']);
			$this->_editValue(_CLMN_CHR_STAT_AGI_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['agi']);
			$this->_editValue(_CLMN_CHR_STAT_VIT_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['vit']);
			$this->_editValue(_CLMN_CHR_STAT_ENE_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['ene']);
			$this->_editValue(_CLMN_CHR_STAT_CMD_, $baseStats[$playerInformation[_CLMN_CHR_CLASS_]]['base_stats']['cmd']);
		}
		
		// reset level up points
		if($this->_resetLevelUpPoints) {
			$this->_editValue(_CLMN_CHR_LVLUP_POINT_, 0);
		}
		
		// reward level up points
		if($this->_rewardLevelUpPoints >= 1) {
			
			$currentLevelUpPoints = $this->_resetLevelUpPoints ? 0 : $playerInformation[_CLMN_CHR_LVLUP_POINT_];
			$newLevelUpPoints = $currentLevelUpPoints+$this->_rewardLevelUpPoints;
			
			if($this->_multiplyRewardLevelUpPoints) {
				$newLevelUpPoints = $currentLevelUpPoints+($newReset*$this->_rewardLevelUpPoints);
			}
			
			$this->_editValue(_CLMN_CHR_LVLUP_POINT_, $newLevelUpPoints);
		}
		
		// rebirth increment
		$this->_editValue(_CLMN_CHR_RSTS_, $newReset);
		
		// rebirth
		if(!$this->_saveEdits()) throw new Exception(lang('error_68'));
	}
	
	
}