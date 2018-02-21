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

class Rankings {
	
	private $_configurationFile = 'rankings';
	private $_cfg;
	
	private $_results;
	private $_excludedCharacters;
	private $_excludedGuilds;
	
	private $_offlineMode = false;
	
	function __construct() {
		
		// offline mode
		if(config('offline_mode')) $this->_offlineMode = true;
		
		if(!config('offline_mode')) {
			$this->mu = Handler::loadDB('MuOnline');
			$this->me = Handler::loadDB('Me_MuOnline');
		}
		
		$this->we = Handler::loadDB('WebEngine');
		$this->config = webengineConfigs();
		$this->serverFiles = $this->config['server_files'];
		
		$cfg = loadModuleConfig($this->_configurationFile);
		if(!is_array($cfg)) throw new Exception(lang('error_66'));
		$this->_cfg = $cfg;
		
		$this->_results = check($this->_cfg['rankings_results']) ? $this->_cfg['rankings_results'] : 25;
		
		$excludedCharacters = explode(",", Filter::RemoveAllSpaces($this->_cfg['rankings_excluded_characters']));
		$this->_excludedCharacters = $excludedCharacters;
		
		$excludedGuilds = explode(",", Filter::RemoveAllSpaces($this->_cfg['rankings_excluded_guilds']));
		$this->_excludedGuilds = $excludedGuilds;
	}
   
	public function updateRankingCache($type) {
		if($this->_offlineMode) return;
		switch($type) {
			case 'level':
				$this->_levelsRanking();
				break;
			case 'resets':
				$this->_resetsRanking();
				break;
			case 'killers':
				$this->_killersRanking();
				break;
			case 'votes':
				$this->_votesRanking();
				break;
			case 'guilds':
				$this->_guildsRanking();
				break;
			case 'gens':
				$this->_gensRanking();
				break;
			default:
				return;
		}
	}
	
	private function _levelsRanking() {
		switch($this->serverFiles) {
			default:
				if($this->_cfg['rankings_sum_master_level']) {
					if(_TBL_CHR_ == _TBL_MASTERLVL_) {
						// level + master level (different tables)
						$players = $this->mu->queryFetch("SELECT TOP ".$this->_results." t1."._CLMN_CHR_NAME_.", t1."._CLMN_CHR_CLASS_.", t1."._CLMN_CHR_LVL_.", t2."._CLMN_ML_LVL_.", t1."._CLMN_CHR_MAP_.", (t1."._CLMN_CHR_LVL_." + t2."._CLMN_ML_LVL_.") as playerLevel FROM "._TBL_CHR_." as t1 INNER JOIN "._TBL_MASTERLVL_." as t2 ON t1."._CLMN_CHR_NAME_." = t2."._CLMN_ML_NAME_." WHERE t1."._CLMN_CHR_NAME_." NOT IN(".$this->_rankingsExcludeChars().") ORDER BY playerLevel DESC");
					} else {
						// level +master level (same tables)
						$players = $this->mu->queryFetch("SELECT TOP ".$this->_results." "._CLMN_CHR_NAME_.", "._CLMN_CHR_CLASS_.", "._CLMN_CHR_LVL_.", "._CLMN_ML_LVL_.", "._CLMN_CHR_MAP_.", ("._CLMN_CHR_LVL_." + "._CLMN_ML_LVL_.") as playerLevel FROM "._TBL_CHR_." WHERE "._CLMN_CHR_NAME_." NOT IN(".$this->_rankingsExcludeChars().") ORDER BY playerLevel DESC");
					}
				} else {
					// level only
					$players = $this->mu->queryFetch("SELECT TOP ".$this->_results." "._CLMN_CHR_NAME_.", "._CLMN_CHR_CLASS_.", "._CLMN_CHR_LVL_.", "._CLMN_CHR_MAP_." FROM "._TBL_CHR_." WHERE "._CLMN_CHR_NAME_." NOT IN(".$this->_rankingsExcludeChars().") ORDER BY "._CLMN_CHR_LVL_." DESC");
				}
				
				// gens
				if($this->_cfg['rankings_show_gens']) {
					if(is_array($players)) {
						$Player = new Player();
						foreach($players as $playerData) {
							$Player->setPlayer($playerData[_CLMN_CHR_NAME_]);
							$gensData = $Player->getGensInformation();
							if(!is_array($gensData)) continue;
							
							$completePlayerData = $playerData;
							$completePlayerData['_gens'] = $gensData;
							
							$result[] = $completePlayerData;
						}
					}
				} else {
					$result = $players;
				}
		}
		if(!is_array($result)) return;
		
		$cache = encodeCache($result);
		updateCache('rankings_level.cache', $cache);
	}
	
	private function _resetsRanking() {
		switch($this->serverFiles) {
			default:
				if($this->_cfg['rankings_sum_master_level']) {
					if(_TBL_CHR_ == _TBL_MASTERLVL_) {
						// level + master level (different tables)
						$players = $this->mu->queryFetch("SELECT TOP ".$this->_results." t1."._CLMN_CHR_NAME_.", t1."._CLMN_CHR_CLASS_.", t1."._CLMN_CHR_RSTS_.", t1."._CLMN_CHR_LVL_.", t2."._CLMN_ML_LVL_.", t1."._CLMN_CHR_MAP_.", (t1."._CLMN_CHR_LVL_." + t2."._CLMN_ML_LVL_.") as playerLevel FROM "._TBL_CHR_." as t1 INNER JOIN "._TBL_MASTERLVL_." as t2 ON t1."._CLMN_CHR_NAME_." = t2."._CLMN_ML_NAME_." WHERE t1."._CLMN_CHR_NAME_." NOT IN(".$this->_rankingsExcludeChars().") ORDER BY t1."._CLMN_CHR_RSTS_." DESC");
					} else {
						// level +master level (same tables)
						$players = $this->mu->queryFetch("SELECT TOP ".$this->_results." "._CLMN_CHR_NAME_.", "._CLMN_CHR_CLASS_.", "._CLMN_CHR_RSTS_.", "._CLMN_CHR_LVL_.", "._CLMN_ML_LVL_.", "._CLMN_CHR_MAP_.", ("._CLMN_CHR_LVL_." + "._CLMN_ML_LVL_.") as playerLevel FROM "._TBL_CHR_." WHERE "._CLMN_CHR_NAME_." NOT IN(".$this->_rankingsExcludeChars().") ORDER BY "._CLMN_CHR_RSTS_." DESC");
					}
				} else {
					// level only
					$players = $this->mu->queryFetch("SELECT TOP ".$this->_results." "._CLMN_CHR_NAME_.", "._CLMN_CHR_CLASS_.", "._CLMN_CHR_RSTS_.", "._CLMN_CHR_LVL_.", "._CLMN_CHR_MAP_." FROM "._TBL_CHR_." WHERE "._CLMN_CHR_NAME_." NOT IN(".$this->_rankingsExcludeChars().") ORDER BY "._CLMN_CHR_RSTS_." DESC");
				}
				
				// gens
				if($this->_cfg['rankings_show_gens']) {
					if(is_array($players)) {
						$Player = new Player();
						foreach($players as $playerData) {
							$Player->setPlayer($playerData[_CLMN_CHR_NAME_]);
							$gensData = $Player->getGensInformation();
							if(!is_array($gensData)) continue;
							
							$completePlayerData = $playerData;
							$completePlayerData['_gens'] = $gensData;
							
							$result[] = $completePlayerData;
						}
					}
				} else {
					$result = $players;
				}
		}
		if(!is_array($result)) return;

		$cache = encodeCache($result);
		updateCache('rankings_resets.cache', $cache);
	}
	
	private function _killersRanking() {
		switch($this->serverFiles) {
			default:
				$players = $this->mu->queryFetch("SELECT TOP ".$this->_results." "._CLMN_CHR_NAME_.", "._CLMN_CHR_CLASS_.", "._CLMN_CHR_PK_KILLS_.", "._CLMN_CHR_MAP_." FROM "._TBL_CHR_." WHERE "._CLMN_CHR_NAME_." NOT IN(".$this->_rankingsExcludeChars().") ORDER BY "._CLMN_CHR_PK_KILLS_." DESC");
				
				// gens
				if($this->_cfg['rankings_show_gens']) {
					if(is_array($players)) {
						$Player = new Player();
						foreach($players as $playerData) {
							$Player->setPlayer($playerData[_CLMN_CHR_NAME_]);
							$gensData = $Player->getGensInformation();
							if(!is_array($gensData)) continue;
							
							$completePlayerData = $playerData;
							$completePlayerData['_gens'] = $gensData;
							
							$result[] = $completePlayerData;
						}
					}
				} else {
					$result = $players;
				}
		}
		if(!is_array($result)) return;

		$cache = encodeCache($result);
		updateCache('rankings_pk.cache', $cache);
	}
	
	private function _guildsRanking() {
		switch($this->serverFiles) {
			default:
				$result = $this->mu->queryFetch("SELECT TOP ".$this->_results." "._CLMN_GUILD_NAME_.", "._CLMN_GUILD_MASTER_.", "._CLMN_GUILD_SCORE_.", "._CLMN_GUILD_LOGO_." FROM "._TBL_GUILD_." WHERE "._CLMN_GUILD_NAME_." NOT IN(".$this->_rankingsExcludeGuilds().") ORDER BY "._CLMN_GUILD_SCORE_." DESC");
				
				// convert guild logo to hex
				if(is_array($result)) {
					foreach($result as $key => $guild) {
						$result[$key][_CLMN_GUILD_LOGO_] = bin2hex($guild[_CLMN_GUILD_LOGO_]);
					}
				}
		}
		if(!is_array($result)) return;

		$cache = encodeCache($result);
		updateCache('rankings_guilds.cache', $cache);
	}
	
	private function _gensRanking() {
		switch($this->serverFiles) {
			default:
				$result = $this->mu->queryFetch("SELECT TOP ".$this->_results." gens."._CLMN_GENS_NAME_.", gens."._CLMN_GENS_POINT_.", gens."._CLMN_GENS_TYPE_.", gens."._CLMN_GENS_RANK_." as gens_rank, char."._CLMN_CHR_CLASS_." FROM "._TBL_GENS_." as gens INNER JOIN "._TBL_CHR_." as char ON gens."._CLMN_GENS_NAME_." = char."._CLMN_CHR_NAME_." ORDER BY gens."._CLMN_GENS_POINT_." DESC");
				
		}
		if(!is_array($result)) return;

		$cache = encodeCache($result);
		updateCache('rankings_gens.cache', $cache);
	}
	
	private function _votesRanking() {
		$voteMonth = date("Y-m-01 00:00");
		$votes = $this->we->queryFetch("SELECT `user_id`, COUNT(*) as `count` FROM "._WE_VOTELOGS_." WHERE `timestamp` >= ? GROUP BY `user_id` ORDER BY `count` DESC LIMIT ?", array($voteMonth, $this->_results));
		if(!is_array($votes)) return;
		
		if(is_array($votes)) {
			$Account = new Account();
			$Player = new Player();
			foreach($votes as $voteData) {
				$Account->setUserid($voteData['user_id']);
				$accountData = $Account->getAccountData();
				if(!is_array($accountData)) continue;
				
				$Player->setUsername($accountData[_CLMN_USERNM_]);
				$playerIDC = $Player->getAccountPlayerIDC();
				if(!check($playerIDC)) continue;
				
				$Player->setPlayer($playerIDC);
				$playerData = $Player->getPlayerInformation();
				if(!is_array($playerData)) continue;
				
				$result[] = array(
					_CLMN_CHR_NAME_ => $playerData[_CLMN_CHR_NAME_],
					_CLMN_CHR_CLASS_ => $playerData[_CLMN_CHR_CLASS_],
					'count' => $voteData['count']
				);
			}
		}
		
		$cache = encodeCache($result);
		updateCache('rankings_votes.cache', $cache);
	}
	
	public function rankingsMenu() {
		$rankings_menu = array(
			array(lang('rankings_txt_1',true), 'level', $this->_cfg['rankings_enable_level']),
			array(lang('rankings_txt_2',true), 'resets', $this->_cfg['rankings_enable_resets']),
			array(lang('rankings_txt_3',true), 'killers', $this->_cfg['rankings_enable_pk']),
			array(lang('rankings_txt_4',true), 'guilds', $this->_cfg['rankings_enable_guilds']),
			array(lang('rankings_txt_7',true), 'votes', $this->_cfg['rankings_enable_votes']),
			array(lang('rankings_txt_8',true), 'gens', $this->_cfg['rankings_enable_gens']),
		);

		echo '<div class="rankings_menu">';
		foreach($rankings_menu as $rm_item) {
			if($rm_item[2]) {
				echo '<a href="'.Handler::websiteLink('rankings/'.$rm_item[1]).'">'.$rm_item[0].'</a>';
			}
		}
		echo '</div>';
	}
	
	private function _rankingsExcludeChars() {
		if(!is_array($this->_excludedCharacters)) return;
		foreach($this->_excludedCharacters as $characterName) {
			$return[] = "'".$characterName."'";
		}
		return implode(",", $return);
	}
	
	private function _rankingsExcludeGuilds() {
		if(!is_array($this->_excludedGuilds)) return;
		foreach($this->_excludedGuilds as $guildName) {
			$return[] = "'".$guildName."'";
		}
		return implode(",", $return);
	}

}