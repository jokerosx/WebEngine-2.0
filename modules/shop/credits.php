<?php
/**
 * WebEngine
 * http://muengine.net/
 * 
 * @version 2.0.0
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2017 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */

echo '<div class="row">';
	echo '<div class="col-xs-6 col-md-4">';
		echo '<a href="'.Handler::websiteLink('shop/credits/paypal').'" class="thumbnail"><img src="'.Handler::templateIMG('paypal.png').'" /></a>';
	echo '</div>';
	echo '<div class="col-xs-6 col-md-4">';
		echo '<a href="'.Handler::websiteLink('shop/credits/paymentwall').'" class="thumbnail"><img src="'.Handler::templateIMG('paymentwall.png').'" /></a>';
	echo '</div>';
	echo '<div class="col-xs-6 col-md-4">';
		echo '<a href="'.Handler::websiteLink('shop/credits/superrewards').'" class="thumbnail"><img src="'.Handler::templateIMG('superrewards.png').'" /></a>';
	echo '</div>';
	echo '<div class="col-xs-6 col-md-4">';
		echo '<a href="'.Handler::websiteLink('shop/credits/mercadopago').'" class="thumbnail"><img src="'.Handler::templateIMG('mercadopago.png').'" /></a>';
	echo '</div>';
	echo '<div class="col-xs-6 col-md-4">';
		echo '<a href="'.Handler::websiteLink('shop/credits/pagseguro').'" class="thumbnail"><img src="'.Handler::templateIMG('pagseguro.png').'" /></a>';
	echo '</div>';
echo '</div>';