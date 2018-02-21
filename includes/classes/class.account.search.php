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

class AccountSearch extends Account {
	
	private $_searchTypes = array(
		'username',
		'email',
		'ip'
	);
	
	private $_type = 'username';
	private $_value;
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * setSearchType
	 * sets the search type
	 */
	public function setSearchType($type) {
		if(!in_array($type, $this->_searchTypes)) throw new Exception(lang('error_116'));
		$this->_type = $type;
	}
	
	/**
	 * setSearchValue
	 * sets the search value
	 */
	public function setSearchValue($value) {
		if(!check($this->_type)) throw new Exception(lang('error_117'));
		$this->_value = $value;
	}
	
	/**
	 * search
	 * searches for accounts based on the search type and value
	 */
	public function search() {
		if(!check($this->_type)) throw new Exception(lang('error_117'));
		if(!check($this->_value)) throw new Exception(lang('error_118'));
		
		$value = '%'.$this->_value.'%';
		
		switch($this->_type) {
			case 'username':
				$result = $this->db->queryFetch("SELECT "._CLMN_USERNM_." as username FROM "._TBL_MI_." WHERE "._CLMN_USERNM_." LIKE ?", array($value));
				break;
			case 'email':
				$result = $this->db->queryFetch("SELECT "._CLMN_USERNM_." as username FROM "._TBL_MI_." WHERE "._CLMN_EMAIL_." LIKE ?", array($value));
				break;
			case 'ip':
				$result = $this->db->queryFetch("SELECT "._CLMN_MS_MEMBID_." as username FROM "._TBL_MS_." WHERE "._CLMN_MS_IP_." LIKE ?", array($value));
				break;
			default:
				throw new Exception('Invalid search type.');
		}
		
		if(!is_array($result)) return;
		return $result;
	}
	
}