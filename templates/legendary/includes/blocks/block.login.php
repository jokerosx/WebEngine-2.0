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

echo '<div class="panel panel-sidebar">';
	echo '<div class="panel-heading">';
		echo '<h3 class="panel-title">'.lang('module_titles_txt_2').' <a href="'.Handler::websiteLink('recovery').'" class="btn btn-xs pull-right">'.lang('login_txt_4').'</a></h3>';
	echo '</div>';
	echo '<div class="panel-body">';
		echo '<form action="'.Handler::websiteLink('login').'" method="post">';
			echo '<div class="form-group">';
				echo '<input type="text" class="form-control" id="loginBox1" name="webengineLogin_user" placeholder="'.lang('login_txt_1').'" required>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<input type="password" class="form-control" id="loginBox2" name="webengineLogin_pwd" placeholder="'.lang('login_txt_2').'" required>';
			echo '</div>';
			$recaptchaCfg = loadConfig('recaptcha');
			if($recaptchaCfg['login']) {
				// recaptcha v2
				echo '<div class="form-group">';
					echo '<div class="g-recaptcha" data-sitekey="'.$recaptchaCfg['site_key'].'" style="transform:scale(0.89);transform-origin:0 0"></div>';
				echo '</div>';
				echo '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
			}
			echo '<button type="submit" name="webengineLogin_submit" value="submit" class="btn btn-primary">'.lang('login_txt_3').'</button>';
		echo '</form>';
	echo '</div>';
echo '</div>';

# join now banner
echo '<div class="sidebar-banner"><a href="'.Handler::websiteLink('register').'"><img src="'.Handler::templateIMG().'register_sidebar_banner.jpg"/></a></div>';

# download banner
echo '<div class="sidebar-banner"><a href="'.Handler::websiteLink('download').'"><img src="'.Handler::templateIMG().'download_sidebar_banner.jpg"/></a></div>';