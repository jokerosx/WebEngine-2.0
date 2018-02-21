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

class Player {
	
	protected $_username;
	protected $_playerid;
	protected $_player;
	
	protected $_playerInformation;
	protected $_playerMasterLevelInformation;
	protected $_playerGensInformation;
	
	protected $_playerEditTable;
	protected $_playerEditNameColumn;
	protected $_playerEditList = array();
	
	
	
	function __construct() {
		
		// offline mode
		if(config('offline_mode')) throw new Exception(lang('offline_mode_error'));
		
		// database object
		$this->db = Handler::loadDB('MuOnline');
		
		// default edit table and name column
		$this->_playerEditTable = _TBL_CHR_;
		$this->_playerEditNameColumn = _CLMN_CHR_NAME_;
	}
	
	/**
	 * setUsername
	 * 
	 */
	public function setUsername($value) {
		if(!check($value)) throw new Exception(lang('error_91'));
		if(!Validator::AccountUsername($value)) throw new Exception(lang('error_91'));
		
		$this->_username = $value;
	}
	
	/**
	 * setPlayer
	 * 
	 */
	public function setPlayer($value) {
		
		$this->_player = $value;
	}
	
	/**
	 * getAccountPlayerList
	 * 
	 */
	public function getAccountPlayerList() {
		if(!check($this->_username)) throw new Exception(lang('error_91'));
		
		$result = $this->db->queryFetchSingle("SELECT "._CLMN_GAMEID_1_.","._CLMN_GAMEID_2_.","._CLMN_GAMEID_3_.","._CLMN_GAMEID_4_.","._CLMN_GAMEID_5_." FROM "._TBL_AC_." WHERE "._CLMN_AC_ID_." = ?", array($this->_username));
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getAccountPlayerIDC
	 * 
	 */
	public function getAccountPlayerIDC() {
		if(!check($this->_username)) throw new Exception(lang('error_91'));
		
		$result = $this->db->queryFetchSingle("SELECT "._CLMN_GAMEIDC_." FROM "._TBL_AC_." WHERE "._CLMN_AC_ID_." = ?", array($this->_username));
		if(!is_array($result)) return;
		return $result[_CLMN_GAMEIDC_];
	}
	
	/**
	 * belongsToAccount
	 * 
	 */
	public function belongsToAccount() {
		if(!check($this->_username)) throw new Exception(lang('error_91'));
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		$accountCharacters = $this->getAccountPlayerList();
		if(!in_array($this->_player, $accountCharacters)) return;
		return true;
	}
	
	/**
	 * getPlayerInformation
	 * 
	 */
	public function getPlayerInformation() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		$this->_loadPlayerInformation();
		if(!is_array($this->_playerInformation)) return;
		return $this->_playerInformation;
	}
	
	/**
	 * getPlayerMasterLevelInformation
	 * 
	 */
	public function getPlayerMasterLevelInformation() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		$this->_loadMasterLevelInformation();
		if(!is_array($this->_playerMasterLevelInformation)) return;
		return $this->_playerMasterLevelInformation;
	}
	
	/**
	 * getGensInformation
	 * 
	 */
	public function getGensInformation() {
		if(!check($this->_player)) throw new Exception(lang('error_24'));
		
		$this->_loadGensInformation();
		if(!is_array($this->_playerGensInformation)) return;
		return $this->_playerGensInformation;
	}
	
	/**
	 * _setEditTable
	 * 
	 */
	public function _setEditTable($table) {
		if(!check($table)) throw new Exception(lang('error_215'));
		
		$this->_playerEditTable = $table;
	}
	
	/**
	 * _setEditNameColumn
	 * 
	 */
	public function _setEditNameColumn($column) {
		if(!check($column)) throw new Exception(lang('error_216'));
		
		$this->_playerEditNameColumn = $column;
	}
	
	/**
	 * _editValue
	 * 
	 */
	public function _editValue($column, $value) {
		if(!check($column, $value)) throw new Exception(lang('error_217'));
		
		$this->_playerEditList[$column] = $value;
	}
	
	/**
	 * _saveEdits
	 * 
	 */
	public function _saveEdits() {
		if(!check($this->_player)) throw new Exception(lang('error_24', true));
		if(!is_array($this->_playerEditList)) throw new Exception(lang('error_218'));
		if(count($this->_playerEditList) < 1) throw new Exception(lang('error_218'));
		
		$columnList = array();
		$valueList = array();
		
		foreach($this->_playerEditList as $column => $value) {
			$columnList[] = $column;
			$valueList[] = $value;
		}
		
		$valueList[] = $this->_player;
		
		$queryColumns = implode(' = ?, ', $columnList) . ' = ?';
		$query = "UPDATE ".$this->_playerEditTable." SET ".$queryColumns." WHERE ".$this->_playerEditNameColumn." = ?";
		
		$result = $this->db->query($query, $valueList);
		if($result) return true;
		return;
	}
	
	/**
	 * getTotalPlayerCount
	 * 
	 */
	public function getTotalPlayerCount() {
		$result = $this->db->queryFetchSingle("SELECT COUNT(*) as total_players FROM "._TBL_CHR_."");
		if(!is_array($result)) return 0;
		if(!check($result['total_players'])) return 0;
		return $result['total_players'];
	}
	
	/**
	 * getTotalGuildCount
	 * 
	 */
	public function getTotalGuildCount() {
		$result = $this->db->queryFetchSingle("SELECT COUNT(*) as total_guilds FROM "._TBL_GUILD_."");
		if(!is_array($result)) return 0;
		if(!check($result['total_guilds'])) return 0;
		return $result['total_guilds'];
	}
	
	/**
	 * _loadPlayerInformation
	 * 
	 */
	protected function _loadPlayerInformation() {
		if(!check($this->_player)) return;
		
		$result = $this->db->queryFetchSingle("SELECT * FROM "._TBL_CHR_." WHERE "._CLMN_CHR_NAME_." = ?", array($this->_player));
		if(!is_array($result)) return;
		$this->_playerInformation = $result;
	}
	
	/**
	 * _loadMasterLevelInformation
	 * 
	 */
	protected function _loadMasterLevelInformation() {
		if(!check($this->_player)) return;
		
		$result = $this->db->queryFetchSingle("SELECT * FROM "._TBL_MASTERLVL_." WHERE "._CLMN_ML_NAME_." = ?", array($this->_player));
		if(!is_array($result)) return;
		$this->_playerMasterLevelInformation = $result;
	}
	
	/**
	 * _loadGensInformation
	 * 
	 */
	protected function _loadGensInformation() {
		if(!check($this->_player)) return;
		
		$result = $this->db->queryFetchSingle("SELECT * FROM "._TBL_GENS_." WHERE "._CLMN_GENS_NAME_." = ?", array($this->_player));
		if(!is_array($result)) return;
		$this->_playerGensInformation = $result;
	}
	
	
	
}