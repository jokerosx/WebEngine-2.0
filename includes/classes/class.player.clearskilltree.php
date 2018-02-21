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

class PlayerClearSkillTree extends Player {
	
	private $_configurationFile = 'character.clearskilltree';
	
	protected $_defaultMasterLevel = 0;
	protected $_defaultMasterLevelExp = 0;
	protected $_defaultMasterLevelNextExp = 0;
	protected $_defaultMasterLevelPoint= 0;
	
	protected $_requiredZen = 0;
	protected $_requiredLevel = 400;
	protected $_requiredMastelLevel = 0;
	
	function __construct() {
		parent::__construct();
		
		$cfg = loadModuleConfig($this->_configurationFile);
		if(!is_array($cfg)) throw new Exception(lang('error_66'));
		
		$this->_requiredZen = $cfg['required_zen'];
		$this->_requiredLevel = $cfg['required_level'];
		$this->_requiredMastelLevel = $cfg['required_master_level'];
	}
	
	public function clearskilltree() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		// get player information
		$playerInformation = $this->getPlayerInformation();
		if(!is_array($playerInformation)) throw new Exception(lang('error_67'));
		
		// get player master level information
		$playerMLInformation = $this->getPlayerMasterLevelInformation();
		if(!is_array($playerMLInformation)) throw new Exception(lang('error_67'));
		
		// check if player belongs to account
		if(!$this->belongsToAccount()) throw new Exception(lang('error_36'));
		
		// edits begin
		$this->_setEditTable(_TBL_MASTERLVL_);
		$this->_setEditNameColumn(_CLMN_ML_NAME_);
		
		// level requirement
		if($this->_requiredLevel >= 1) {
			if($playerInformation[_CLMN_CHR_LVL_] < $this->_requiredLevel) throw new Exception(lang('error_33'));
		}
		
		// zen requirement
		if($this->_requiredZen >= 1) {
			if($playerInformation[_CLMN_CHR_ZEN_] < $this->_requiredZen) throw new Exception(lang('error_34'));
			$this->_editValue(_CLMN_CHR_ZEN_, ($playerInformation[_CLMN_CHR_ZEN_]-$this->_requiredZen));
		}
		
		// master level requirement
		if($this->_requiredMastelLevel >= 1) {
			if($playerMLInformation[_CLMN_ML_LVL_] < $this->_requiredMastelLevel) throw new Exception(lang('error_39'));
		}
		
		// master level
		$this->_editValue(_CLMN_ML_LVL_, $this->_defaultMasterLevel);
		$this->_editValue(_CLMN_ML_EXP_, $this->_defaultMasterLevelExp);
		$this->_editValue(_CLMN_ML_NEXP_, $this->_defaultMasterLevelNextExp);
		$this->_editValue(_CLMN_ML_POINT_, $this->_defaultMasterLevelPoint);
		
		// clear skill tree
		if(!$this->_clearMagicList()) throw new Exception(lang('error_74'));
		
		// save
		if(!$this->_saveEdits()) throw new Exception(lang('error_74'));
	}
	
	private function _clearMagicList() {
		if(!check($this->_player)) return;
		
		$result = $this->db->query("UPDATE "._TBL_CHR_." SET "._CLMN_CHR_MAGIC_L_." = null WHERE "._CLMN_CHR_NAME_." = ?", array($this->_player));
		if(!$result) return;
		return true;
	}
	
}