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

class Account {
	
	protected $_userid;
	protected $_username;
	protected $_password;
	protected $_newPassword;
	protected $_email;
	protected $_serial = '111111111111';
	
	protected $_accountData;
	protected $_verificationKey;
	
	protected $_facebookId;
	protected $_facebookName;
	protected $_googleId;
	protected $_googleName;
	
	function __construct() {
		
		// offline mode
		if(config('offline_mode')) throw new Exception(lang('offline_mode_error'));
		
		// database object
		$this->db = config('SQL_USE_2_DB') ? Handler::loadDB('Me_MuOnline') : Handler::loadDB('MuOnline');
		
		// md5
		$this->_md5Enabled = config('SQL_ENABLE_MD5');
	}
	
	/**
	 * setVerificationKey
	 * sets the verification key value
	 */
	public function setVerificationKey($value) {
		if(!check($value)) throw new Exception(lang('error_27'));
		if(!Validator::Number($value)) throw new Exception(lang('error_27'));
		if(!Validator::UnsignedNumber($value)) throw new Exception(lang('error_27'));
		
		$this->_verificationKey = $value;
	}
	
	/**
	 * setUserid
	 * sets the user id
	 */
	public function setUserid($value) {
		if(!check($value)) throw new Exception(lang('error_90'));
		if(!Validator::AccountId($value)) throw new Exception(lang('error_90'));
		
		$this->_userid = $value;
	}
	
	/**
	 * setUsername
	 * sets the username
	 */
	public function setUsername($value) {
		if(!check($value)) throw new Exception(lang('error_91'));
		if(!Validator::AccountUsername($value)) throw new Exception(lang('error_91'));
		
		$this->_username = $value;
	}
	
	/**
	 * setPassword
	 * sets the password
	 */
	public function setPassword($value) {
		if(!check($value)) throw new Exception(lang('error_1'));
		if(!Validator::AccountPassword($value)) throw new Exception(lang('error_1'));
		
		$this->_password = $value;
	}
	
	/**
	 * setNewPassword
	 * sets the new password
	 */
	public function setNewPassword($value) {
		if(!check($value)) throw new Exception(lang('error_92'));
		if(!Validator::AccountPassword($value)) throw new Exception(lang('error_92'));
		
		$this->_newPassword = $value;
	}
	
	/**
	 * setEmail
	 * sets the email
	 */
	public function setEmail($value) {
		if(!check($value)) throw new Exception(lang('error_9'));
		if(!Validator::AccountEmail($value)) throw new Exception(lang('error_9'));
		
		$this->_email = $value;
	}
	
	/**
	 * setFacebookId
	 * sets the facebook user identifier
	 */
	public function setFacebookId($id) {
		if(!Validator::FacebookId($id)) throw new Exception(lang('error_81'));
		$this->_facebookId = $id;
	}
	
	/**
	 * setGoogleId
	 * sets the google user identifier
	 */
	public function setGoogleId($id) {
		if(!Validator::GoogleId($id)) throw new Exception(lang('error_82'));
		$this->_googleId = $id;
	}
	
	/**
	 * setFacebookName
	 * sets the facebook name
	 */
	public function setFacebookName($name) {
		if(!Validator::FacebookName($name)) throw new Exception(lang('error_81'));
		$this->_facebookName = $name;
	}
	
	/**
	 * setGoogleName
	 * sets the google name
	 */
	public function setGoogleName($name) {
		if(!Validator::GoogleName($name)) throw new Exception(lang('error_82'));
		$this->_googleName = $name;
	}
	
	/**
	 * usernameExists
	 * checks if the username is in use
	 */
	public function usernameExists() {
		if(!check($this->_username)) return;
		$result = $this->db->queryFetchSingle("SELECT "._CLMN_USERNM_." FROM "._TBL_MI_." WHERE "._CLMN_USERNM_." = ?", array($this->_username));
		if(!is_array($result)) return;
		return true;
	}
	
	/**
	 * emailExists
	 * checks if the email address is in use
	 */
	public function emailExists($email='') {
		$checkEmail = check($email) ? $email : $this->_email;
		if(!check($checkEmail)) return;
		$result = $this->db->queryFetchSingle("SELECT "._CLMN_EMAIL_." FROM "._TBL_MI_." WHERE "._CLMN_EMAIL_." = ?", array($checkEmail));
		if(!is_array($result)) return;
		return true;
	}
	
	/**
	 * getAccountData
	 * returns the account data
	 */
	public function getAccountData() {
		$this->_loadAccountData();
		return $this->_accountData;
	}
	
	/**
	 * blockAccount
	 * bans an account depending on the identificator set
	 */
	public function blockAccount() {
		if(check($this->_userid)) {
			$result = $this->db->query("UPDATE "._TBL_MI_." SET "._CLMN_BLOCCODE_." = ? WHERE "._CLMN_MEMBID_." = ?", array(1, $this->_userid));
			if(!$result) return;
			return true;
		}
		
		if(check($this->_username)) {
			$result = $this->db->query("UPDATE "._TBL_MI_." SET "._CLMN_BLOCCODE_." = ? WHERE "._CLMN_USERNM_." = ?", array(1, $this->_username));
			if(!$result) return;
			return true;
		}
		
		if(check($this->_email)) {
			$result = $this->db->query("UPDATE "._TBL_MI_." SET "._CLMN_BLOCCODE_." = ? WHERE "._CLMN_EMAIL_." = ?", array(1, $this->_email));
			if(!$result) return;
			return true;
		}
		
		return;
	}
	
	/**
	 * unblockAccount
	 * unbans an account depending on the identificator set
	 */
	public function unblockAccount() {
		if(check($this->_userid)) {
			$result = $this->db->query("UPDATE "._TBL_MI_." SET "._CLMN_BLOCCODE_." = ? WHERE "._CLMN_MEMBID_." = ?", array(0, $this->_userid));
			if(!$result) return;
			return true;
		}
		
		if(check($this->_username)) {
			$result = $this->db->query("UPDATE "._TBL_MI_." SET "._CLMN_BLOCCODE_." = ? WHERE "._CLMN_USERNM_." = ?", array(0, $this->_username));
			if(!$result) return;
			return true;
		}
		
		if(check($this->_email)) {
			$result = $this->db->query("UPDATE "._TBL_MI_." SET "._CLMN_BLOCCODE_." = ? WHERE "._CLMN_EMAIL_." = ?", array(0, $this->_email));
			if(!$result) return;
			return true;
		}
		
		return;
	}
	
	/**
	 * isOnline
	 * checks if the account is online
	 */
	public function isOnline() {
		if(check($this->_username)) {
			$result = $this->db->queryFetchSingle("SELECT "._CLMN_CONNSTAT_." FROM "._TBL_MS_." WHERE "._CLMN_USERNM_." = ? AND "._CLMN_CONNSTAT_." = ?", array($this->_username, 1));
			if(!is_array($result)) return;
			return true;
		}
		
		$accountData = $this->getAccountData();
		if(is_array($accountData)) {
			$result = $this->db->queryFetchSingle("SELECT "._CLMN_CONNSTAT_." FROM "._TBL_MS_." WHERE "._CLMN_USERNM_." = ? AND "._CLMN_CONNSTAT_." = ?", array($accountData[_CLMN_USERNM_], 1));
			if(!is_array($result)) return;
			return true;
		}
		
		return;
	}
	
	/**
	 * getFullAccountList
	 * returns a list of all accounts on the database
	 */
	public function getFullAccountList() {
		$result = $this->db->queryFetch("SELECT "._CLMN_MEMBID_.", "._CLMN_USERNM_.", "._CLMN_EMAIL_." FROM "._TBL_MI_." ORDER BY "._CLMN_MEMBID_." ASC");
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getOnlineAccountList
	 * returns a list of all accounts connected to the game
	 */
	public function getOnlineAccountList() {
		$result = $this->db->queryFetch("SELECT * FROM "._TBL_MS_." WHERE "._CLMN_CONNSTAT_." = ?", array(1));
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getBannedAccountsList
	 * returns a list of all banned accounts
	 */
	public function getBannedAccountsList() {
		$result = $this->db->queryFetch("SELECT "._CLMN_MEMBID_.", "._CLMN_USERNM_.", "._CLMN_EMAIL_." FROM "._TBL_MI_." WHERE "._CLMN_BLOCCODE_." = 1 ORDER BY "._CLMN_MEMBID_." ASC");
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getTotalAccountCount
	 * xxx
	 */
	public function getTotalAccountCount() {
		$result = $this->db->queryFetchSingle("SELECT COUNT(*) as total_accounts FROM "._TBL_MI_."");
		if(!is_array($result)) return 0;
		if(!check($result['total_accounts'])) return 0;
		return $result['total_accounts'];
	}
	
	/**
	 * getTotalOnlineAccountCount
	 * xxx
	 */
	public function getTotalOnlineAccountCount() {
		$result = $this->db->queryFetchSingle("SELECT COUNT(*) as total_online FROM "._TBL_MS_." WHERE "._CLMN_CONNSTAT_." = ?", array(1));
		if(!is_array($result)) return 0;
		if(!check($result['total_online'])) return 0;
		return $result['total_online'];
	}
	
	/**
	 * recoverUsername
	 * username recovery process
	 */
	public function recoverUsername() {
		if(!check($this->_email)) throw new Exception(lang('error_4',true));
		
		$accountData = $this->getAccountData();
		if(!is_array($accountData)) throw new Exception(lang('error_12',true));
		$this->setUsername($accountData[_CLMN_USERNM_]);
		
		if(!$this->_sendUsernameRecoveryEmail()) throw new Exception(lang('error_25',true));
	}
	
	/**
	 * _loadAccountData
	 * loads the account data depending on the identificator set
	 */
	protected function _loadAccountData() {
		if(check($this->_userid)) {
			$result = $this->db->queryFetchSingle("SELECT * FROM "._TBL_MI_." WHERE "._CLMN_MEMBID_." = ?", array($this->_userid));
			if(!is_array($result)) return;
			$this->_accountData = $result;
			return;
		}
		
		if(check($this->_username)) {
			$result = $this->db->queryFetchSingle("SELECT * FROM "._TBL_MI_." WHERE "._CLMN_USERNM_." = ?", array($this->_username));
			if(!is_array($result)) return;
			$this->_accountData = $result;
			return;
		}
		
		if(check($this->_email)) {
			$result = $this->db->queryFetchSingle("SELECT * FROM "._TBL_MI_." WHERE "._CLMN_EMAIL_." = ?", array($this->_email));
			if(!is_array($result)) return;
			$this->_accountData = $result;
			return;
		}
		
		return;
	}
	
	/**
	 * _createAccount
	 * creates a new account in the database
	 */
	protected function _createAccount() {
		if(!check($this->_username)) return;
		if(!check($this->_password)) return;
		if(!check($this->_email)) return;
		
		$data = array(
			'username' => $this->_username,
			'password' => $this->_password,
			'name' => $this->_username,
			'serial' => $this->_serial,
			'email' => $this->_email
		);
		
		if($this->_md5Enabled) {
			$query = "INSERT INTO "._TBL_MI_." ("._CLMN_USERNM_.", "._CLMN_PASSWD_.", "._CLMN_MEMBNAME_.", "._CLMN_SNONUMBER_.", "._CLMN_EMAIL_.", "._CLMN_BLOCCODE_.", "._CLMN_CTLCODE_.") VALUES (:username, [dbo].[fn_md5](:password, :username), :name, :serial, :email, 0, 0)";
		} else {
			$query = "INSERT INTO "._TBL_MI_." ("._CLMN_USERNM_.", "._CLMN_PASSWD_.", "._CLMN_MEMBNAME_.", "._CLMN_SNONUMBER_.", "._CLMN_EMAIL_.", "._CLMN_BLOCCODE_.", "._CLMN_CTLCODE_.") VALUES (:username, :password, :name, :serial, :email, 0, 0)";
		}
		
		$result = $this->db->query($query, $data);
		if(!$result) return;
		
		return true;
	}
	
	/**
	 * _validateAccount
	 * checks if the username and password are correct
	 */
	protected function _validateAccount() {
		if(!check($this->_username)) return;
		if(!check($this->_password)) return;
		$data = array(
			'username' => $this->_username,
			'password' => $this->_password
		);
		if($this->_md5Enabled) {
			$query = "SELECT * FROM "._TBL_MI_." WHERE "._CLMN_USERNM_." = :username AND "._CLMN_PASSWD_." = [dbo].[fn_md5](:password, :username)";
		} else {
			$query = "SELECT * FROM "._TBL_MI_." WHERE "._CLMN_USERNM_." = :username AND "._CLMN_PASSWD_." = :password";
		}
		
		$result = $this->db->queryFetchSingle($query, $data);
		if(!is_array($result)) return;
		
		return true;
	}
	
	/**
	 * _generateVerificationKey
	 * generates a 6-digit random number
	 */
	protected function _generateVerificationKey() {
		return mt_rand(111111,999999);
	}
	
	/**
	 * _updatePassword
	 * changes the account password
	 */
	protected function _updatePassword() {
		if(!check($this->_userid)) return;
		if(!check($this->_username)) return;
		if(!check($this->_newPassword)) return;
		if($this->_md5Enabled) {
			$data = array(
				'userid' => $this->_userid,
				'username' => $this->_username,
				'newpassword' => $this->_newPassword
			);
			$query = "UPDATE "._TBL_MI_." SET "._CLMN_PASSWD_." = [dbo].[fn_md5](:newpassword, :username) WHERE "._CLMN_MEMBID_." = :userid";
		} else {
			$data = array(
				'userid' => $this->_userid,
				'newpassword' => $this->_newPassword
			);
			$query = "UPDATE "._TBL_MI_." SET "._CLMN_PASSWD_." = :newpassword WHERE "._CLMN_MEMBID_." = :userid";
		}
		
		$result = $this->db->query($query, $data);
		if(!$result) return;
		
		return true;
	}
	
	/**
	 * _sendPasswordRecoveryVerificationEmail
	 * sends the password recovery verification email to the user
	 */
	private function _sendUsernameRecoveryEmail() {
		if(!check($this->_username)) return;
		if(!check($this->_email)) return;
		try {
			$email = new Email();
			$email->setTemplate('USERNAME_RECOVERY');
			$email->addVariable('{USERNAME}', $this->_username);
			$email->addAddress($this->_email);
			$email->send();
			return true;
		} catch (Exception $ex) {
			# TODO logs system
			return;
		}
	}
	
}