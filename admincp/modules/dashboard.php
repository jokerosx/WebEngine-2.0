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

@checkVersion();

echo '<div class="row">';
	
	// WebEngine Info
	echo '<div class="col-sm-12 col-md-6 col-lg-6">';
		echo '<div class="card">';
			echo '<div class="header">General Information</div>';
			echo '<div class="content table-responsive">';
				
				echo 'WebEngine '.__WEBENGINE_VERSION__.'<br />';
				echo 'https://webenginecms.org/<br /><br />';
				
				echo 'Base Url<br />';
				echo __BASE_URL__ . '<br /><br />';
				
				echo 'Master Cron Job Path<br />';
				echo __PATH_CRON__ . 'cron.php<br /><br />';
				
				echo 'WebEngine Database Path<br />';
				echo __PATH_INCLUDES__ . 'webengine.db<br /><br />';
				
				echo 'WebEngine Database Size<br />';
				echo readableFileSize(filesize(__PATH_INCLUDES__.'webengine.db')).'<br /><br />';
				
				echo 'PHP Version<br />';
				echo phpversion().'<br /><br />';
				
				echo 'Operating System<br />';
				echo PHP_OS.'<br /><br />';
				
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	// Other Software
	echo '<div class="col-sm-12 col-md-6 col-lg-6">';
		echo '<div class="card">';
			echo '<div class="header">Other Software</div>';
			echo '<div class="content table-responsive">';
				
				echo 'jQuery 3.2.1 (CDN)<br />';
				echo 'http://jquery.com/<br /><br />';

				echo 'Bootstrap 3.3.5<br />';
				echo 'https://getbootstrap.com/<br /><br />';

				echo 'Light Bootstrap Dashboard 1.3.1<br />';
				echo 'https://www.creative-tim.com/product/light-bootstrap-dashboard<br /><br />';

				echo 'PHPMailer 5.2.26<br />';
				echo 'https://github.com/PHPMailer/PHPMailer/<br /><br />';

				echo 'ReCaptcha (v2) PHP Client Library 1.1.3<br />';
				echo 'https://github.com/google/recaptcha<br /><br />';

				echo 'CKEditor 4.8.0 (CDN)<br />';
				echo 'https://ckeditor.com<br /><br />';

				echo 'CodeMirror 5.33.0 (CDN)<br />';
				echo 'https://github.com/codemirror/CodeMirror<br /><br />';

				echo 'SweetAlert2 7.4.0 (CDN)<br />';
				echo 'https://github.com/limonte/sweetalert2<br /><br />';

				echo 'Hybridauth 3.0.0 RC1<br />';
				echo 'https://github.com/hybridauth/hybridauth<br /><br />';
				
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
echo '</div>';