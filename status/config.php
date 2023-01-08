<?php
$base_url = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https":"http");
$base_url .= "://".$_SERVER['HTTP_HOST'];
$base_url .= substr(str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER["SCRIPT_NAME"]), 0, -1);



/* Configuration of the site */
define('DATABASE_SERVER',   'localhost');
define('DATABASE_USERNAME', 'root');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME',     'siteiptv_gestorlite');
define('SITE_URL',          $base_url);

