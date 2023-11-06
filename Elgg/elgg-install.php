<?php 
/**
 * Docker CLI Elgg installer script 
 */
$autoload_path = '/var/www/html/vendor/autoload.php';
$autoload_available = include_once($autoload_path);
if (!$autoload_available) {
	die("Couldn't include '$autoload_path'. Did you run `composer install`?");
}

$params = [
	'timezone' => getenv('TIMEZONE'),
  
  // database parameters
	'dbhost' => getenv('ELGG_DB_HOST'),
	'dbprefix' => getenv('ELGG_DB_PREFIX'),
	'dbuser' => getenv('ELGG_DB_USER'),
	'dbpassword' => getenv('ELGG_DB_PASS'),
	'dbname' => getenv('ELGG_DB_NAME'),
	
  // site settings
	'sitename' => getenv('ELGG_SITE_NAME'),
	'siteemail' => getenv('ELGG_SITE_EMAIL'),
	'wwwroot' => getenv('ELGG_WWW_ROOT'),
	'dataroot' => getenv('ELGG_DATA_ROOT'),
	'siteaccess' => getenv('ELGG_SITE_ACCESS'),
	
  // admin account
	'displayname' => getenv('ELGG_DISPLAY_NAME'),
	'email' => getenv('ELGG_EMAIL'),
	'username' => getenv('ELGG_USERNAME'),
	'password' => getenv('ELGG_PASSWORD'),
	'path' => getenv('ELGG_PATH'),
];

if (strlen($params['password']) < 6) {
    echo "Elgg Admin password ({$params['password']}) must be at least 6 characters long.\n";
    exit(1);
}

$installer = new ElggInstaller();
$installer->batchInstall($params);

echo "Installation is complete.\n";
echo "Open in your browser: {$params['wwwroot']}\n";
echo "Elgg access credentials:\n";
echo "Elgg admin username: {$params['username']}\n";
echo "Elgg admin pass: {$params['password']}\n";

exit(0);