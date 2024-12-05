<?php
	DEFINE("BASEPATH", "/");
	
	/* Database Config */
	// DEFINE("DB_HOST", "25.17.48.249");
	
	DEFINE("DB_HOST", "25.61.111.198");
	DEFINE("DB_USER", "vlad");
	DEFINE("DB_PASS", "vl@d1m1r");
	DEFINE("DB_NAME", "skinology");
	DEFINE("DB_PORT", 3306);
	
	/* Server Config */
	Define("SERVER_TIMEZONE", "Asia/Manila");
	Define("SERVER_MAINTENANCE", false);
	
	/* Website Config */
	Define("WEBSITE_HOMEPAGE", "main");

	Define("WEBSITE_TITLE", "Skinology");
	Define("WEBSITE_TITLE_ACRO", "SKN");
	Define("WEBSITE_LOGO", "/assets/custom/images/skinology-nbg.png");
	Define("WEBSITE_LOGO_FAVICON", "/assets/custom/images/skinology.jpg");

	/* Default value  */
	Define("DEFAULT_REGISTER_REGION", 9);
	Define("DEFAULT_REGISTER_PROVINCE", 48);
	Define("DEFAULT_REGISTER_CITY", 0);
	Define("DEFAULT_REGISTER_BARANGAY", 0);
	Define("DEFAULT_UPLOAD_DIR", "assets/upload/");

	Define("DEFAULT_FOOTER_COPYRIGHT", '
		<div class="copyright">© '. date('Y') .'. All rights reserved. </div>
	');

	DEFINE('ROOT_URL', '/');
	Define("DEBUG_MODE", true);

	$var_service = array();
	$var_service["cash_pickup"] = new stdClass();
	$var_service["cash_pickup"]->id = 1;
	$var_service["cash_pickup"]->title = "Cash Pick Up";

	$var_service["lcf"] = new stdClass();
	$var_service["lcf"]->id = 2;
	$var_service["lcf"]->title = "Loose Change Fund";

	$var_service["cash_delivery"] = new stdClass();
	$var_service["cash_delivery"]->id = 5;
	$var_service["cash_delivery"]->title = "Cash Delivery";
	
	$var_service["card_delivery"] = new stdClass();
	$var_service["card_delivery"]->id = 8;
	$var_service["card_delivery"]->title = "Card Delivery";

	$var_service["remittance"] = new stdClass();
	$var_service["remittance"]->id = 9;
	$var_service["remittance"]->title = "Remittance";
?>
