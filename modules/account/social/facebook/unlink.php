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

// social configurations
$socialCfg = loadConfig('social');
if(!is_array($socialCfg)) throw new Exception(lang('error_66'));

// social status
if(!$socialCfg['enabled'] || !$socialCfg['provider']['facebook']['enabled']) redirect('account/profile');

// account preferences
$AccountPreferences = new AccountPreferences();
$AccountPreferences->setUsername($_SESSION['username']);

// unlink
if(!$AccountPreferences->unlinkFacebook()) throw new Exception(lang('error_83', array(Handler::websiteLink('account/profile'))));

// redirect
redirect('account/profile');