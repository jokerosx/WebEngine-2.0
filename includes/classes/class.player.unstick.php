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

class PlayerUnstick extends Player {
	
	private $_configurationFile = 'character.unstick';
	
	protected $_requiredLevel = 0;
	protected $_requiredZen = 0;
	protected $_map = 0;
	protected $_coordx = 125;
	protected $_coordy = 125;
	
	function __construct() {
		parent::__construct();
		
		$cfg = loadModuleConfig($this->_configurationFile);
		if(!is_array($cfg)) throw new Exception(lang('error_66'));
		
		$this->_requiredLevel = $cfg['required_level'];
		$this->_requiredZen = $cfg['required_zen'];
		$this->_map = $cfg['map'];
		$this->_coordx = $cfg['coord_x'];
		$this->_coordy = $cfg['coord_y'];
	}
	
	public function unstick() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		// get player information
		$playerInformation = $this->getPlayerInformation();
		if(!is_array($playerInformation)) throw new Exception(lang('error_67'));
		
		// check if player belongs to account
		if(!$this->belongsToAccount()) throw new Exception(lang('error_37'));
		
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
		
		// location reset
		$this->_editValue(_CLMN_CHR_MAP_, $this->_map);
		$this->_editValue(_CLMN_CHR_MAP_X_, $this->_coordx);
		$this->_editValue(_CLMN_CHR_MAP_Y_, $this->_coordy);
		
		// unstick
		if(!$this->_saveEdits()) throw new Exception(lang('error_69'));
	}
	
}