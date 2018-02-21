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

// module configs
$cfg = loadModuleConfig('account.profile');
if(!is_array($cfg)) throw new Exception(lang('error_66'));

// social configs
$socialCfg = loadConfig('social');
$socialLoginStatus = is_array($socialCfg) ? $socialCfg['enabled'] : 0;

// account information
$Account = new Account();
$Account->setUserid($_SESSION['userid']);
$accountInfo = $Account->getAccountData();
if(!is_array($accountInfo)) throw new Exception(lang('error_12'));

// account online status
$onlineStatus = $Account->isOnline() ? '<span class="label label-success">'.lang('status_online').'</span>' : '<span class="label label-danger">'.lang('status_offline').'</span>';

// characters info
$Player = new Player();
$Player->setUsername($accountInfo[_CLMN_USERNM_]);
$accountPlayerList = $Player->getAccountPlayerList();

// account ban status
$accountBanStatus = $accountInfo[_CLMN_BLOCCODE_];
if($accountBanStatus) {
	message('warning', 'Your account is currently banned, for more information you may open a support ticket.');
}

// account information
if($cfg['show_account_info']) {
	echo '<h4>'.lang('account_txt_1').'</h4>';
	echo '<table class="table account-table">';
		echo '<tr>';
			echo '<th>'.lang('account_txt_2').'</th>';
			echo '<td>'.$accountInfo[_CLMN_USERNM_].'</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<th>'.lang('account_txt_3').'</th>';
			echo '<td>'.$accountInfo[_CLMN_EMAIL_].'<a href="'.Handler::websiteLink('account/email').'" class="btn btn-xs btn-primary pull-right">'.lang('account_txt_6').'</a></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<th>'.lang('account_txt_4').'</th>';
			echo '<td>******<a href="'.Handler::websiteLink('account/password').'" class="btn btn-xs btn-primary pull-right">'.lang('account_txt_6').'</a></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<th>'.lang('account_txt_5').'</th>';
			echo '<td>'.$onlineStatus.'</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<th>'.lang('account_txt_15').'</th>';
			echo '<td>';
				if(is_array($accountPlayerList)) {
					foreach($accountPlayerList as $playerName) {
						if(!check($playerName)) continue;
						echo playerProfile($playerName);
						echo '<br />';
					}
				}
			echo '</td>';
		echo '</tr>';
	echo '</table>';
}

// social accounts linked
if($cfg['show_social_info'] && $socialLoginStatus) {
	
	// account preferences
	$AccountPreferences = new AccountPreferences();
	$AccountPreferences->setUsername($accountInfo[_CLMN_USERNM_]);
	$accountPreferencesData = $AccountPreferences->getAccountPreferencesFromUsername();
	$facebookAccount = check($accountPreferencesData['facebook_id']) ? '<a href="'.facebookProfile($accountPreferencesData['facebook_id']).'" target="_blank">'.$accountPreferencesData['facebook_name'].'</a>' : '<span class="text-alt">'.lang('account_txt_24').'</span>';
	$facebookButton = check($accountPreferencesData['facebook_id']) ? '<a href="'.Handler::websiteLink('account/social/facebook/unlink').'" class="btn btn-xs btn-primary pull-right">'.lang('account_txt_26').'</a>' : '<a href="'.Handler::websiteLink('account/social/facebook/link').'" class="btn btn-xs btn-primary pull-right">'.lang('account_txt_25').'</a>';
	$googleAccount = check($accountPreferencesData['google_id']) ? '<a href="'.googleProfile($accountPreferencesData['google_id']).'" target="_blank">'.$accountPreferencesData['google_name'].'</a>' : '<span class="text-alt">'.lang('account_txt_24').'</span>';
	$googleButton = check($accountPreferencesData['google_id']) ? '<a href="'.Handler::websiteLink('account/social/google/unlink').'" class="btn btn-xs btn-primary pull-right">'.lang('account_txt_26').'</a>' : '<a href="'.Handler::websiteLink('account/social/google/link').'" class="btn btn-xs btn-primary pull-right">'.lang('account_txt_25').'</a>';
	
	echo '<h4>'.lang('account_txt_21').'</h4>';
	echo '<table class="table account-table">';
	if($socialCfg['provider']['facebook']['enabled']) {
		echo '<tr>';
			echo '<th>'.lang('account_txt_22').'</th>';
			echo '<td>'.$facebookAccount.' '.$facebookButton.'</td>';
		echo '</tr>';
	}
	if($socialCfg['provider']['google']['enabled']) {
		echo '<tr>';
			echo '<th>'.lang('account_txt_23').'</th>';
			echo '<td>'.$googleAccount.' '.$googleButton.'</td>';
		echo '</tr>';
	}
	echo '</table>';
}

// account credits
if($cfg['show_credits_info']) {
	try {
		$creditSystem = new CreditSystem();
		$creditCofigList = $creditSystem->showConfigs();
		if(is_array($creditCofigList)) {
			foreach($creditCofigList as $myCredits) {
				try {
					if(!$myCredits['config_display']) continue;
					$creditSystem->setConfigId($myCredits['config_id']);
					switch($myCredits['config_user_col_id']) {
						case 'userid':
							$creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
							break;
						case 'username':
							$creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
							break;
						case 'email':
							$creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
							break;
						default:
							continue;
					}
					$configCredits = $creditSystem->getCredits();
					$configTitle = lang($myCredits['config_phrase']) == 'ERROR' ? $myCredits['config_phrase'] : lang($myCredits['config_phrase']);
					$showCredits[] = array($configTitle, $configCredits);
				} catch(Exception $ex) {}
			}
		}
		if(is_array($showCredits)) {
			echo '<h4>'.lang('account_txt_7').'</h4>';
			echo '<table class="table account-table">';
			foreach($showCredits as $creditsData) {
				echo '<tr>';
					echo '<th>'.$creditsData[0].'</th>';
					echo '<td>'.number_format($creditsData[1]).'<a href="'.Handler::websiteLink('shop/credits').'" class="btn btn-xs btn-primary pull-right">'.lang('account_txt_8').'</a></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
	} catch(Exception $ex) {}
}

// account ban history
if($cfg['show_ban_info']) {
	
	// account ban history
	$AccountBan = new AccountBan();
	$AccountBan->setUserid($accountInfo[_CLMN_MEMBID_]);
	$banHistory = $AccountBan->getAccountBanList();
	
	if(is_array($banHistory)) {
		echo '<h4>'.lang('account_txt_9').'</h4>';
		echo '<table class="table account-table">';
			foreach($banHistory as $banData) {
				$banStatus = $banData['ban_lifted'] == 1 ? '<span class="label label-default">'.lang('account_txt_13').'</span>' : '<span class="label label-success">'.lang('account_txt_12').'</span>';
				echo '<tr>';
					echo '<th>'.databaseTime($banData['ban_date']).'</th>';
					echo '<td>'.ucfirst($banData['ban_type']).'</td>';
					echo '<td>'.$banStatus.'</td>';
					echo '<td class="text-right"><a href="'.Handler::websiteLink('account/ban/id/'.$banData['ban_id']).'" class="btn btn-xs btn-primary">'.lang('account_txt_10').'</a></td>';
				echo '</tr>';
			}
		echo '</table>';
	}
}