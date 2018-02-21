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

class CreditSystem {
	
	private $_configId;
	private $_identifier;
	
	private $_configTitle;
	private $_configDatabase;
	private $_configTable;
	private $_configCreditsCol;
	private $_configUserCol;
	private $_configUserColId;
	private $_configCheckOnline = true;
	private $_configDisplay = false;
	private $_configPhrase = null;
	
	private $_allowedUserColId = array(
		'userid',
		'username',
		'email',
		'character'
	);
	
	private $_limit = 100;
	
	function __construct() {
		
		$this->character = new Player();
		$this->muonline = Handler::loadDB('MuOnline');
		if($this->muonline->dead) throw new Exception(lang('error_89'));
		
		if(config('SQL_USE_2_DB')) {
			$this->memuonline = Handler::loadDB('Me_MuOnline');
			if($this->memuonline->dead) throw new Exception(lang('error_89'));
		}
		
		$this->db = Handler::loadDB('WebEngine');
	}
	
	/**
	 * setIdentifier
	 * 
	 */
	public function setIdentifier($input) {
		if(!$this->_configId) throw new Exception(lang('error_126'));
		$config = $this->showConfigs(true);
		
		switch($config['config_user_col_id']) {
			case 'userid':
				$this->_setUserid($input);
				break;
			case 'username':
				$this->_setUsername($input);
				break;
			case 'email':
				$this->_setEmail($input);
				break;
			case 'character':
				$this->_setCharacter($input);
				break;
			default:
				throw new Exception(lang('error_127'));
		}
	}
	
	/**
	 * addCredits
	 * adds credits to an account or character depending on the cofiguration set
	 * @param int $input
	 * @throws Exception
	 */
	public function addCredits($input) {
		if(!Validator::UnsignedNumber($input)) throw new Exception(lang('error_128'));
		if(!$this->_configId) throw new Exception(lang('error_126'));
		if(!$this->_identifier) throw new Exception(lang('error_127'));
		
		// get configs
		$config = $this->showConfigs(true);
		
		// check online
		if($config['config_checkonline']) {
			if($this->_isOnline($config['config_user_col_id'])) throw new Exception(lang('error_28'));
		}
		
		// check current credits
		$currentCredits = $this->getCredits();
		
		// choose database
		$database = $config['config_database'] == "MuOnline" ? $this->muonline : $this->memuonline;
		
		// build query
		$data = array(
			'credits' => $input,
			'identifier' => $this->_identifier
		);
		$variables = array('{TABLE}','{COLUMN}','{USER_COLUMN}');
		$values = array($config['config_table'], $config['config_credits_col'], $config['config_user_col']);
		
		if(check($currentCredits)) {
			$query = str_replace($variables, $values, "UPDATE {TABLE} SET {COLUMN} = {COLUMN} + :credits WHERE {USER_COLUMN} = :identifier");
		} else {
			$query = str_replace($variables, $values, "UPDATE {TABLE} SET {COLUMN} = :credits WHERE {USER_COLUMN} = :identifier");
		}
		
		// add credits
		$addCredits = $database->query($query, $data);
		if(!$addCredits) throw new Exception(lang('error_129'));
		
		$this->_addLog($config['config_title'], $input, "add");
	}
	
	/**
	 * subtractCredits
	 * subtracts credits from an account or character depending on the configuration set
	 * @param type $input
	 * @throws Exception
	 */
	public function subtractCredits($input) {
		if(!Validator::UnsignedNumber($input)) throw new Exception(lang('error_128'));
		if(!$this->_configId) throw new Exception(lang('error_126'));
		if(!$this->_identifier) throw new Exception(lang('error_127'));
		
		// get configs
		$config = $this->showConfigs(true);
		
		// check online
		if($config['config_checkonline']) {
			if($this->_isOnline($config['config_user_col_id'])) throw new Exception(lang('error_28'));
		}
		
		// check current credits
		if($this->getCredits() < $input) throw new Exception(lang('error_40'));
		
		// choose database
		$database = $config['config_database'] == "MuOnline" ? $this->muonline : $this->memuonline;
		
		// build query
		$data = array(
			'credits' => $input,
			'identifier' => $this->_identifier
		);
		$variables = array('{TABLE}','{COLUMN}','{USER_COLUMN}');
		$values = array($config['config_table'], $config['config_credits_col'], $config['config_user_col']);
		$query = str_replace($variables, $values, "UPDATE {TABLE} SET {COLUMN} = {COLUMN} - :credits WHERE {USER_COLUMN} = :identifier");
		
		// add credits
		$addCredits = $database->query($query, $data);
		if(!$addCredits) throw new Exception(lang('error_130'));
		
		$this->_addLog($config['config_title'], $input, "subtract");
	}
	
	/**
	 * setConfigId
	 * sets the configuration id (from the database)
	 * @param int $input
	 * @throws Exception
	 */
	public function setConfigId($input) {
		if(!Validator::UnsignedNumber($input)) throw new Exception(lang('error_131'));
		if(!$this->_configurationExists($input)) throw new Exception(lang('error_131'));
		$this->_configId = $input;
	}
	
	/**
	 * setConfigtitle
	 * sets the title for the new configuration
	 * @param string $input
	 * @throws Exception
	 */
	public function setConfigTitle($input) {
		if(!Validator::Chars($input, array('a-z', 'A-Z', '0-9', ' '))) throw new Exception(lang('error_132'));
		$this->_configTitle = $input;
	}
	
	/**
	 * setConfigPhrase
	 * sets the language phrase for the new configuration
	 * @param string $input
	 * @throws Exception
	 */
	public function setConfigPhrase($input) {
		if(!Validator::Chars($input, array('a-z', 'A-Z', '0-9', ' ', '_'))) throw new Exception(lang('error_133'));
		if(lang($input) == 'ERROR') throw new Exception(lang('error_134'));
		$this->_configPhrase = $input;
	}
	
	/**
	 * setConfigDatabase
	 * sets the database for the new configuration
	 * @param string $input
	 * @throws Exception
	 */
	public function setConfigDatabase($input) {
		if(!Validator::Chars($input, array('a-z', 'A-Z', '0-9', '_'))) throw new Exception(lang('error_135'));
		$this->_configDatabase = $input;
	}
	
	/**
	 * setConfigtable
	 * sets the table for the new configuration
	 * @param string $input
	 * @throws Exception
	 */
	public function setConfigTable($input) {
		if(!Validator::Chars($input, array('a-z', 'A-Z', '0-9', '_'))) throw new Exception(lang('error_136'));
		$this->_configTable = $input;
	}
	
	/**
	 * setConfigCreditsColumn
	 * sets the credits column for the new configuration
	 * @param string $input
	 * @throws Exception
	 */
	public function setConfigCreditsColumn($input) {
		if(!Validator::Chars($input, array('a-z', 'A-Z', '0-9', '_'))) throw new Exception(lang('error_137'));
		$this->_configCreditsCol = $input;
	}
	
	/**
	 * setConfigUserColumn
	 * sets the user column for the new configuration
	 * @param string $input
	 * @throws Exception
	 */
	public function setConfigUserColumn($input) {
		if(!Validator::Chars($input, array('a-z', 'A-Z', '0-9', '_'))) throw new Exception(lang('error_138'));
		$this->_configUserCol = $input;
	}
	
	/**
	 * setConfigUserColumnId
	 * sets the user column identifier for the new configuration
	 * @param string $input
	 * @throws Exception
	 */
	public function setConfigUserColumnId($input) {
		if(!Validator::AlphaNumeric($input)) throw new Exception(lang('error_139'));
		if(!in_array($input, $this->_allowedUserColId)) throw new Exception(lang('error_139'));
		$this->_configUserColId = $input;
	}
	
	/**
	 * setConfigCheckOnline
	 * sets the online check for the new configuration
	 * @param boolean $input
	 */
	public function setConfigCheckOnline($input) {
		$this->_configCheckOnline = ($input ? 1 : 0);
	}
	
	/**
	 * setConfigDisplay
	 * sets the config display in myaccoutn module for the new configuration
	 * @param boolean $input
	 */
	public function setConfigDisplay($input) {
		$this->_configDisplay = ($input ? 1 : 0);
	}
	
	/**
	 * saveConfig
	 * inserts the new configuration to the database
	 * @throws Exception
	 */
	public function saveConfig() {
		if(!$this->_configTitle) throw new Exception(lang('error_4'));
		if(!$this->_configDatabase) throw new Exception(lang('error_4'));
		if(!$this->_configTable) throw new Exception(lang('error_4'));
		if(!$this->_configCreditsCol) throw new Exception(lang('error_4'));
		if(!$this->_configUserCol) throw new Exception(lang('error_4'));
		if(!$this->_configUserColId) throw new Exception(lang('error_4'));
		
		$data = array(
			'title' => $this->_configTitle,
			'database' => $this->_configDatabase,
			'table' => $this->_configTable,
			'creditscol' => $this->_configCreditsCol,
			'usercol' => $this->_configUserCol,
			'usercolid' => $this->_configUserColId,
			'checkonline' => $this->_configCheckOnline,
			'display' => $this->_configDisplay,
			'phrase' => $this->_configPhrase
		);
		
		$query = "INSERT INTO "._WE_CREDITSYS_." "
			. "(config_title, config_database, config_table, config_credits_col, config_user_col, config_user_col_id, config_checkonline, config_display, config_phrase) "
			. "VALUES "
			. "(:title, :database, :table, :creditscol, :usercol, :usercolid, :checkonline, :display, :phrase)";
		
		$saveConfig = $this->db->query($query, $data);
		if(!$saveConfig) throw new Exception(lang('error_140'));
	}
	
	/**
	 * editConfig
	 * edits a configuration from the database
	 * @throws Exception
	 */
	public function editConfig() {
		if(!$this->_configId) throw new Exception(lang('error_4'));
		if(!$this->_configTitle) throw new Exception(lang('error_4'));
		if(!$this->_configDatabase) throw new Exception(lang('error_4'));
		if(!$this->_configTable) throw new Exception(lang('error_4'));
		if(!$this->_configCreditsCol) throw new Exception(lang('error_4'));
		if(!$this->_configUserCol) throw new Exception(lang('error_4'));
		if(!$this->_configUserColId) throw new Exception(lang('error_4'));
		
		$data = array(
			'id' => $this->_configId,
			'title' => $this->_configTitle,
			'database' => $this->_configDatabase,
			'table' => $this->_configTable,
			'creditscol' => $this->_configCreditsCol,
			'usercol' => $this->_configUserCol,
			'usercolid' => $this->_configUserColId,
			'checkonline' => $this->_configCheckOnline,
			'display' => $this->_configDisplay,
			'phrase' => $this->_configPhrase
		);
		
		$query = "UPDATE "._WE_CREDITSYS_." SET "
			. "config_title = :title, "
			. "config_database = :database, "
			. "config_table = :table, "
			. "config_credits_col = :creditscol, "
			. "config_user_col= :usercol, "
			. "config_user_col_id = :usercolid,"
			. "config_checkonline = :checkonline, "
			. "config_display = :display, "
			. "config_phrase = :phrase "
			. "WHERE config_id = :id";
		
		$editConfig = $this->db->query($query, $data);
		if(!$editConfig) throw new Exception(lang('error_141'));
	}
	
	/**
	 * deleteConfig
	 * deletes a configuration from the database
	 * @throws Exception
	 */
	public function deleteConfig() {
		if(!$this->_configId) throw new Exception(lang('error_126'));
		if(!$this->db->query("DELETE FROM "._WE_CREDITSYS_." WHERE config_id = ?", array($this->_configId))) {
			throw new Exception(lang('error_142'));
		}
	}
	
	/**
	 * showConigs
	 * returns all or a single configuration from the database
	 * @param boolean $singleConfig
	 * @return array
	 * @throws Exception
	 */
	public function showConfigs($singleConfig = false) {
		if($singleConfig) {
			if(!$this->_configId) throw new Exception(lang('error_126'));
			return $this->db->queryFetchSingle("SELECT * FROM "._WE_CREDITSYS_." WHERE config_id = ?", array($this->_configId));
		} else {
			$result = $this->db->queryFetch("SELECT * FROM "._WE_CREDITSYS_." ORDER BY config_id ASC");
			if($result) return $result;
			return false;
		}
	}
	
	/**
	 * buildSelectInput
	 * builds a select input with all the configurations
	 * @param string $name
	 * @param int $default
	 * @param string $class
	 * @return string
	 */
	public function buildSelectInput($name="creditsconfig", $default=0, $class="") {
		$selectName = Validator::Chars($name, array('a-z', 'A-Z', '0-9', '_')) ? $name : "creditsconfig";
		$selectedOption = Validator::UnsignedNumber($default) ? $default : 1;
		$configs = $this->showConfigs();
		$return = $class ? '<select name="'.$selectName.'" class="'.$class.'">' : '<select name="'.$selectName.'">';
		if(is_array($configs)) {
			if($default == 0) {
				$return .= '<option value="0" selected>none</option>';
			} else {
				$return .= '<option value="0">none</option>';
			}
			foreach($configs as $config) {
				if($selectedOption == $config['config_id']) {
					$return .= '<option value="'.$config['config_id'].'" selected>'.$config['config_title'].'</option>';
				} else {
					$return .= '<option value="'.$config['config_id'].'">'.$config['config_title'].'</option>';
				}
			}
		} else {
			$return .= '<option value="0" selected>none</option>';
		}
		$return .= '</select>';
		return $return;
	}
	
	/**
	 * getLogs
	 * returns an array of logs from the database
	 * @return array
	 */
	public function getLogs() {
		if(check($this->_identifier)) {
			if($this->_limit > 0) {
				$result = $this->db->queryFetch("SELECT * FROM "._WE_CREDITSYSLOG_." WHERE `log_identifier` = ? ORDER BY `log_id` DESC LIMIT ?", array($this->_identifier, $this->_limit));
			} else {
				$result = $this->db->queryFetch("SELECT * FROM "._WE_CREDITSYSLOG_." WHERE `log_identifier` = ? ORDER BY `log_id` DESC", array($this->_identifier));
			}
		} else {
			if($this->_limit > 0) {
				$result = $this->db->queryFetch("SELECT * FROM "._WE_CREDITSYSLOG_." ORDER BY `log_id` DESC LIMIT ?", array($this->_limit));
			} else {
				$result = $this->db->queryFetch("SELECT * FROM "._WE_CREDITSYSLOG_." ORDER BY `log_id` DESC");
			}
		}
		if(is_array($result)) return $result;
	}
	
	/**
	 * getCredits
	 * returns the available credits of the user
	 * @return int
	 */
	public function getCredits() {
		if(!$this->_configId) throw new Exception(lang('error_126'));
		if(!$this->_identifier) throw new Exception(lang('error_127'));
		
		// get configs
		$config = $this->showConfigs(true);
		
		// choose database
		$database = $config['config_database'] == "MuOnline" ? $this->muonline : $this->memuonline;
		
		// build query
		$data = array(
			'identifier' => $this->_identifier
		);
		$variables = array('{TABLE}','{COLUMN}','{USER_COLUMN}');
		$values = array($config['config_table'], $config['config_credits_col'], $config['config_user_col']);
		$query = str_replace($variables, $values, "SELECT {COLUMN} FROM {TABLE} WHERE {USER_COLUMN} = :identifier");
		
		// add credits
		$getCredits = $database->queryFetchSingle($query, $data);
		if(!is_array($getCredits)) throw new Exception(lang('error_143'));
		
		return $getCredits[$config['config_credits_col']];
	}
	
	/**
	 * setLimit
	 * sets the log display limit
	 * @param int $limit
	 * @throws Exception
	 */
	public function setLimit($limit) {
		if(!Validator::UnsignedNumber($limit)) throw new Exception(lang('error_98'));
		$this->_limit = $limit;
	}
	
	/**
	 * setCustomIdentifier
	 * sets a custom identifier
	 * @param int $input
	 */
	public function setCustomIdentifier($input) {
		$this->_identifier = $input;
	}
	
	/**
	 * _configurationExists
	 * checks if the configuration exists in the database
	 * @param int $input
	 * @return boolean
	 */
	private function _configurationExists($input) {
		$check = $this->db->queryFetchSingle("SELECT * FROM "._WE_CREDITSYS_." WHERE config_id = ?", array($input));
		if($check) return true;
		return false;
	}
	
	/**
	 * _setUserId
	 * sets the userid identifier
	 * @param int $input
	 * @throws Exception
	 */
	private function _setUserid($input) {
		if(!Validator::UnsignedNumber($input)) throw new Exception(lang('error_90'));
		$this->_identifier = $input;
	}
	
	/**
	 * _setUsername
	 * sets the username identifier
	 * @param string $input
	 * @throws Exception
	 */
	private function _setUsername($input) {
		if(!Validator::AlphaNumeric($input)) throw new Exception(lang('error_91'));
		if(!Validator::UsernameLength($input)) throw new Exception(lang('error_91'));
		$this->_identifier = $input;
	}
	
	/**
	 * _setEmail
	 * sets the email identifier
	 * @param string $input
	 * @throws Exception
	 */
	private function _setEmail($input) {
		if(!Validator::Email($input)) throw new Exception(lang('error_9'));
		$this->_identifier = $input;
	}
	
	/**
	 * _setCharacter
	 * sets the character name identifier
	 * @param string $input
	 * @throws Exception
	 */
	private function _setCharacter($input) {
		if(!Validator::AlphaNumeric($input)) throw new Exception(lang('error_144'));
		$this->_identifier = $input;
	}
	
	/**
	 * _isOnline
	 * checks if the account is online
	 * @param string $input
	 * @return boolean
	 * @throws Exception
	 */
	private function _isOnline($input) {
		if(!$this->_identifier) throw new Exception(lang('error_145'));
		
		$Account = new Account();
		
		switch($input) {
			case 'userid':
				$Account->setUserid($this->_identifier);
				return $Account->isOnline();
				break;
			case 'username':
				$Account->setUsername($this->_identifier);
				return $Account->isOnline();
				break;
			case 'email':
				$Account->setEmail($this->_identifier);
				return $Account->isOnline();
				break;
			case 'character':
				// get account username from character data
				$this->character->setPlayer($this->_identifier);
				$characterData = $this->character->getPlayerInformation();
				if(!$characterData) throw new Exception(lang('error_146'));
				
				// check online status
				$Account->setUsername($characterData[_CLMN_CHR_ACCID_]);
				return $Account->isOnline();
				break;
			default:
				throw new Exception(lang('error_145'));
		}
	}
	
	/**
	 * _addLog
	 * saves a log of credits transactions
	 * @param string $configTitle
	 * @param int $credits
	 * @param string $transaction
	 */
	private function _addLog($configTitle="unknown", $credits=0, $transaction="unknown") {
		$inadmincp = defined('access') && access == 'admincp' ? 1 : 0;		
		$module = check($_GET['request']) ? $_GET['request'] : '/';
		$ip = Handler::userIP();
		
		$data = array(
			'config' => $configTitle,
			'identifier' => $this->_identifier,
			'credits' => $credits,
			'transaction' => $transaction,
			'inadmincp' => $inadmincp,
			'module' => $module,
			'ip' => $ip
		);
		
		$query = "INSERT INTO "._WE_CREDITSYSLOG_." "
			. "(`log_config`, `log_identifier`, `log_credits`, `log_transaction`, `log_date`, `log_inadmincp`, `log_module`, `log_ip`) "
			. "VALUES "
			. "(:config, :identifier, :credits, :transaction, CURRENT_TIMESTAMP, :inadmincp, :module, :ip)";
		
		$saveLog = $this->db->query($query, $data);
	}
	
}