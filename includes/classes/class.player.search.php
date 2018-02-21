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

class PlayerSearch extends Player {
	
	function __construct() {
		parent::__construct();
	}
	
	/**
	 * search
	 * searches for characters based on the player name
	 */
	public function search() {
		if(!check($this->_player)) throw new Exception(lang('error_144'));
		
		$value = '%'.$this->_player.'%';
		$result = $this->db->queryFetch("SELECT "._CLMN_CHR_NAME_." as name FROM "._TBL_CHR_." WHERE "._CLMN_CHR_NAME_." LIKE ?", array($value));
		
		if(!is_array($result)) return;
		return $result;
	}
	
}