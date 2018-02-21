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

// login module configurations
$cfg = loadModuleConfig('login');
if(!is_array($cfg)) throw new Exception(lang('error_66'));

// login module status
if(!$cfg['active']) throw new Exception(lang('error_47'));

// social configurations
$socialCfg = loadConfig('social');
if(!is_array($socialCfg)) throw new Exception(lang('error_66'));

// social status
if(!$socialCfg['enabled'] || !$socialCfg['provider']['facebook']['enabled']) throw new Exception(lang('error_79', array(Handler::websiteLink('login'))));

// adapter configuration
$adapterConfig = adapterConfig('facebook', 'social/login/facebook');
if(!is_array($adapterConfig)) throw new Exception(lang('error_85'));

try {
	
	// hybridauth
	try {
		$adapter = new Hybridauth\Provider\Facebook($adapterConfig);
		$adapter->authenticate();
		$isConnected = $adapter->isConnected();
		$userProfile = $adapter->getUserProfile();
		$adapter->disconnect();
	} catch(Exception $ex) {
		if(config('debug')) {
			throw new Exception($ex->getMessage());
		} else {
			throw new Exception(lang('error_80', array(Handler::websiteLink('login'))));
		}
	}
	
	// check social id
	if(!check($userProfile->identifier)) throw new Exception(lang('error_80', array(Handler::websiteLink('login'))));
	
	// account login
	$Login = new AccountLogin();
	$Login->setFacebookId($userProfile->identifier);
	$Login->facebookLogin();
	
	// redirect
	redirect('account/profile');
	
} catch(Exception $ex) {
	if($adapter) $adapter->disconnect();
    message('error', $ex->getMessage());
}