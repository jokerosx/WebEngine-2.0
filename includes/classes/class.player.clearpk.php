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

class PlayerClearPk extends Player {
	
	private $_configurationFile = 'character.clearpk';
	
	protected $_defaultPkLevel = 3;
	protected $_requiredLevel = 0;
	protected $_requiredZen = 0;
	
	function __construct() {
		parent::__construct();
		
		$cfg = loadModuleConfig($this->_configurationFile);
		if(!is_array($cfg)) throw new Exception(lang('error_66'));
		
		$this->_requiredLevel = $cfg['required_level'];
		$this->_requiredZen = $cfg['required_zen'];
		$this->_defaultPkLevel = $cfg['default_pk_level'];
	}
	
	public function clearpk() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		// get player information
		$playerInformation = $this->getPlayerInformation();
		if(!is_array($playerInformation)) throw new Exception(lang('error_67'));
		
		// check if player belongs to account
		if(!$this->belongsToAccount()) throw new Exception(lang('error_36'));
		
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
		
		// pk level
		$this->_editValue(_CLMN_CHR_PK_LEVEL_, $this->_defaultPkLevel);
		$this->_editValue(_CLMN_CHR_PK_TIME_, 0);
		
		// clear pk
		if(!$this->_saveEdits()) throw new Exception(lang('error_70'));
	}
	
}