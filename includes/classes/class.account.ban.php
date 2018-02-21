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

class AccountBan extends Account {
	
	private $_banId;
	private $_banBy;
	private $_banType = 'permanent';
	private $_banDuration = 86400;
	private $_banReason;
	
	private $_banReasonMaxLen = 100;
	private $_allowedBanTypes = array(
		'permanent',
		'temporal'
	);
	
	private $_limit = 0;
	private $_commonBanDurations = array(
		0 => 'Permanent',
		300 => '5 minutes',
		600 => '10 minutes',
		900 => '15 minutes',
		1800 => '30 minutes',
		3600 => '1 hour',
		21600 => '6 hours',
		43200 => '12 hours',
		86400 => '1 day',
		259200 => '3 days',
		604800 => '7 days',
		1296000 => '15 days',
		2592000 => '1 month',
		7776000 => '3 months',
		15552000 => '6 months',
		31104000 => '1 year',
	);
	
	function __construct() {
		parent::__construct();
		
		// database object
		$this->we = Handler::loadDB('WebEngine');
	}
	
	/**
	 * setBanId
	 * sets the ban id
	 */
	public function setBanId($id) {
		if(!Validator::UnsignedNumber($id)) throw new Exception(lang('error_93'));
		$this->_banId = $id;
	}
	
	/**
	 * setBanBy
	 * sets the ban author
	 */
	public function setBanBy($username) {
		if(!Validator::AccountUsername($username)) throw new Exception(lang('error_94'));
		$this->_banBy = $username;
	}
	
	/**
	 * setBanType
	 * sets the ban type
	 */
	public function setBanType($type) {
		if(!in_array($type, $this->_allowedBanTypes)) throw new Exception(lang('error_95'));
		$this->_banType = $type;
	}
	
	/**
	 * setBanDuration
	 * sets the ban duration in seconds
	 */
	public function setBanDuration($seconds) {
		if(!Validator::UnsignedNumber($seconds)) throw new Exception(lang('error_96'));
		$this->_banDuration = $seconds;
	}
	
	/**
	 * setBanReason
	 * sets the ban reason
	 */
	public function setBanReason($reason) {
		if(!Validator::Length($reason, $this->_banReasonMaxLen, 0)) throw new Exception(lang('error_97'));
		$this->_banReason = $reason;
	}
	
	/**
	 * setLimit
	 * sets the ban list results limit
	 */
	public function setLimit($limit) {
		if(!Validator::UnsignedNumber($limit)) throw new Exception(lang('error_98'));
		$this->_limit = $limit;
	}
	
	/**
	 * getBanInformation
	 * returns the ban information from the database
	 */
	public function getBanInformation() {
		if(!check($this->_banId)) throw new Exception(lang('error_99'));
		
		$result = $this->we->queryFetchSingle("SELECT * FROM "._WE_BANS_." WHERE `ban_id` = ?", array($this->_banId));
		if(!is_array($result)) throw new Exception(lang('error_100'));
		return $result;
	}
	
	/**
	 * getAccountBanList
	 * returns the list of bans of a given account
	 */
	public function getAccountBanList() {
		if(!check($this->_userid)) throw new Exception(lang('error_101'));
		
		$result = $this->we->queryFetch("SELECT * FROM "._WE_BANS_." WHERE `user_id` = ? ORDER BY `ban_date` DESC", array($this->_userid));
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getBanList
	 * returns a list of bans from the database
	 */
	public function getBanList() {
		if($this->_limit >= 1) {
			$query = "SELECT * FROM "._WE_BANS_." ORDER BY `ban_date` DESC LIMIT ?";
			$result = $this->we->queryFetch($query, array($this->_limit));
			if(!is_array($result)) return;
			return $result;
		}
		
		$query = "SELECT * FROM "._WE_BANS_." ORDER BY `ban_date` DESC";
		$result = $this->we->queryFetch($query);
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getActiveBanList
	 * returns a list of active bans from the database
	 */
	public function getActiveBanList() {
		if($this->_limit >= 1) {
			$query = "SELECT * FROM "._WE_BANS_." WHERE `ban_type` = ? AND `ban_lifted` = 0 ORDER BY `ban_date` DESC LIMIT ?";
			$result = $this->we->queryFetch($query, array($this->_banType, $this->_limit));
			if(!is_array($result)) return;
			return $result;
		}
		
		$query = "SELECT * FROM "._WE_BANS_." WHERE `ban_type` = ? AND `ban_lifted` = 0 ORDER BY `ban_date` DESC";
		$result = $this->we->queryFetch($query, array($this->_banType));
		if(!is_array($result)) return;
		return $result;
	}
	
	/**
	 * getCommonBanDurations
	 * returns the common ban durations list
	 */
	public function getCommonBanDurations() {
		return $this->_commonBanDurations;
	}
	
	/**
	 * formatBanDuration
	 * returns a formatted string of the ban duration
	 */
	public function formatBanDuration($seconds) {
		$banDuration = sec_to_dhms($seconds);
		$banDurationDisplay = '';
		if($banDuration[0] >= 1) $banDurationDisplay .= $banDuration[0] . 'd';
		if($banDuration[1] >= 1) $banDurationDisplay .= ' ' . $banDuration[1] . 'h';
		if($banDuration[2] >= 1) $banDurationDisplay .= ' ' . $banDuration[2] . 'm';
		return $banDurationDisplay;
	}
	
	/**
	 * ban
	 * bans an account
	 */
	public function ban() {
		if(!check($this->_username)) throw new Exception(lang('error_102'));
		if(!check($this->_banType)) throw new Exception(lang('error_103'));
		if(!check($this->_banBy)) throw new Exception(lang('error_104'));
		
		$banReason = check($this->_banReason) ? $this->_banReason : null;
		
		$accountData = $this->getAccountData();
		if(!is_array($accountData)) throw new Exception(lang('error_105'));
		if($accountData[_CLMN_BLOCCODE_] == 1) throw new Exception(lang('error_106'));
		if($this->isOnline()) throw new Exception(lang('error_107'));
		
		if($this->_banType == 'permanent') {
			// permanent ban
			
			$data = array(
				'userid' => $accountData[_CLMN_MEMBID_],
				'by' => $this->_banBy,
				'type' => $this->_banType,
				'reason' => $banReason
			);
			
			$query = "INSERT INTO "._WE_BANS_." (`user_id`, `ban_by`, `ban_type`, `ban_date`, `ban_reason`) VALUES (:userid, :by, :type, CURRENT_TIMESTAMP, :reason)";
		
		} else {
			// temporal ban
			
			if(!check($this->_banDuration)) throw new Exception('error 4');
			
			$data = array(
				'userid' => $accountData[_CLMN_MEMBID_],
				'by' => $this->_banBy,
				'type' => $this->_banType,
				'duration' => $this->_banDuration,
				'reason' => $banReason
			);
			
			$query = "INSERT INTO "._WE_BANS_." (`user_id`, `ban_by`, `ban_type`, `ban_date`, `ban_duration`, `ban_reason`) VALUES (:userid, :by, :type, CURRENT_TIMESTAMP, :duration, :reason)";
			
		}
		
		$ban = $this->blockAccount();
		if(!$ban) throw new Exception(lang('error_108'));
		
		$result = $this->we->query($query, $data);
		if(!$result) throw new Exception(lang('error_109'));
	}
	
	/**
	 * lift
	 * lifts a ban
	 */
	public function lift() {
		if(!check($this->_banId)) throw new Exception(lang('error_110'));
		
		$banInformation = $this->getBanInformation();
		if(!is_array($banInformation)) throw new Exception(lang('error_100'));
		if($banInformation['ban_lifted'] == 1) throw new Exception(lang('error_111'));
		
		$this->setUserid($banInformation['user_id']);
		
		$accountData = $this->getAccountData();
		if(!is_array($accountData)) throw new Exception(lang('error_105'));
		if($this->isOnline()) throw new Exception(lang('error_107'));
		
		$unban = $this->unblockAccount();
		if(!$unban) throw new Exception(lang('error_112'));
		
		$result = $this->we->query("UPDATE "._WE_BANS_." SET `ban_lifted` = 1 WHERE `ban_id` = ?", array($this->_banId));
		if(!$result) throw new Exception(lang('error_113'));
	}
	
	/**
	 * liftCompletedTemporalBans
	 * lifts temporal bans that have completed the ban duration
	 */
	public function liftCompletedTemporalBans() {
		$this->setBanType('temporal');
		
		$banList = $this->getActiveBanList();
		if(!is_array($banList)) return;
		
		foreach($banList as $banData) {
			$banDateTimestamp = strtotime(databaseTime($banData['ban_date']));
			$banLiftDate = $banDateTimestamp+$banData['ban_duration'];
			if(time() > $banLiftDate) {
				// lift ban
				$this->setBanId($banData['ban_id']);
				$this->lift();
			}
		}
	}
	
}