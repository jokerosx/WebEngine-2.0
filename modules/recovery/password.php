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

// recaptcha configs
$recaptchaCfg = loadConfig('recaptcha');
if(!is_array($recaptchaCfg)) throw new Exception(lang('error_66'));

// text
echo '<p>'.lang('recovery_txt_4').'</p><br />';

// form submit
if(check($_POST['webenginePasswordRecovery_submit'])) {
	try {
		if($recaptchaCfg['password_recovery']) {
			$recaptcha = new \ReCaptcha\ReCaptcha($recaptchaCfg['secret_key']);
			
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], Handler::userIP());
			if(!$resp->isSuccess()) {
				// recaptcha failed
				$errors = $resp->getErrorCodes();
				throw new Exception(lang('error_18'));
			}
		}
		
		$Recovery = new AccountPassword();
		$Recovery->setEmail($_POST['webengineEmail']);
		$Recovery->recoverPassword();
		message('success', lang('success_6'));
	} catch (Exception $ex) {
		message('error', $ex->getMessage());
	}
}

// form
echo '<div class="row">';
	echo '<div class="col-xs-12">';
		echo '<form action="" method="post">';
			echo '<div class="form-group">';
				echo '<label for="webengineEmail">'.lang('recovery_txt_5').'</label>';
				echo '<input type="text" class="form-control" id="webengineEmail" name="webengineEmail" required autofocus>';
			echo '</div>';
			
			// recaptcha
			if($recaptchaCfg['password_recovery']) {
				echo '<div class="form-group">';
					echo '<div class="g-recaptcha" data-sitekey="'.$recaptchaCfg['site_key'].'"></div>';
				echo '</div>';
				echo '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
			}
			
			echo '<div class="form-group">';
				echo '<button type="submit" name="webenginePasswordRecovery_submit" value="submit" class="btn btn-primary">'.lang('recovery_txt_6').'</button>';
			echo '</div>';
		echo '</form>';
	echo '</div>';
echo '</div>';