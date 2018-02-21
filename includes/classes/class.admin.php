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

class Admin {
	
	/**
	 * getAccessLevel
	 * 
	 */
	public static function getAccessLevel($username) {
		if(!check($username)) return 0;
		if(!Validator::AccountUsername($username)) return 0;
		
		$we = Handler::loadDB('WebEngine');
		$adminData = $we->queryFetchSingle("SELECT * FROM `WebEngine_AdminAccess` WHERE `username` = ?", array($username));
		if(!is_array($adminData)) return 0;
		return $adminData['access_level'];
	}
	
	/**
	 * getAdminData
	 * 
	 */
	public static function getAdminData($username) {
		if(!check($username)) return;
		if(!Validator::AccountUsername($username)) return;
		
		$we = Handler::loadDB('WebEngine');
		$adminData = $we->queryFetchSingle("SELECT * FROM `WebEngine_AdminAccess` WHERE `username` = ?", array($username));
		if(!is_array($adminData)) return;
		return $adminData;
	}
	
	/**
	 * getAdminList
	 * 
	 */
	public static function getAdminList() {
		$we = Handler::loadDB('WebEngine');
		$result = $we->queryFetch("SELECT * FROM `WebEngine_AdminAccess`");
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * removeAdmin
	 * 
	 */
	public static function removeAdmin($username) {
		$adminData = self::getAdminData($username);
		if(!is_array($adminData)) throw new Exception(lang('error_119'));
		if($username == $_SESSION['username']) throw new Exception(lang('error_120'));
		
		$we = Handler::loadDB('WebEngine');
		$result = $we->query("DELETE FROM `WebEngine_AdminAccess` WHERE `username` = ?", array($username));
		if(!$result) return;
		return true;
	}
	
	/**
	 * addAdmin
	 * 
	 */
	public static function addAdmin($username, $accessLevel=0) {
		if(!Validator::AccountUsername($username)) throw new Exception(lang('error_91'));
		if(!Validator::Number($accessLevel, 100, 0)) throw new Exception(lang('error_121'));
		
		$Account = new Account();
		$Account->setUsername($username);
		if(!$Account->usernameExists()) throw new Exception(lang('error_2'));
		
		$adminData = self::getAdminData($username);
		if(is_array($adminData)) throw new Exception(lang('error_122'));
		
		$we = Handler::loadDB('WebEngine');
		$result = $we->query("INSERT INTO `WebEngine_AdminAccess` (`username`, `access_level`) VALUES (?, ?)", array($username, $accessLevel));
		if(!$result) throw new Exception(lang('error_123'));
	}
	
	/**
	 * editAdmin
	 * 
	 */
	public static function editAdmin($username, $accessLevel=0) {
		if(!Validator::AccountUsername($username)) throw new Exception(lang('error_91'));
		if(!Validator::Number($accessLevel, 100, 0)) throw new Exception(lang('error_121'));
		
		$Account = new Account();
		$Account->setUsername($username);
		if(!$Account->usernameExists()) throw new Exception(lang('error_2'));
		
		$adminData = self::getAdminData($username);
		if(!is_array($adminData)) throw new Exception(lang('error_124'));
		
		$we = Handler::loadDB('WebEngine');
		$result = $we->query("UPDATE `WebEngine_AdminAccess` SET `access_level` = ? WHERE `username` = ?", array($accessLevel, $username));
		if(!$result) throw new Exception(lang('error_125'));
	}
	
}