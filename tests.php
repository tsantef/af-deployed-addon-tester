<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require 'vendor/.composer/autoload.php'; 
require 'lib/test-helper.php';
require_once 'vendor/swiftmailer/swiftmailer/lib/swift_required.php';

$mongo = null;

//pr($_SERVER); 


h2("MongoHQ");

h3("Environment Variables");
validate("'MONGOHQ_URL' exists", array_key_exists("MONGOHQ_URL", $_SERVER) && $_SERVER["MONGOHQ_URL"] <> "");

h3("Service Test");
validate("Connection valid", function () use (&$mongo) {

	// Open connection to MongoLab
	$mongo = new Mongo($_SERVER["MONGOHQ_URL"]);
	return $mongo->connected == 1;

});
validate("Database valid", function () use (&$mongo) {

	// Get database name
	preg_match('@/([^/]+?)$@i', $_SERVER["MONGOHQ_URL"], $matches);
	$db_name = $matches[1];

	// Connect to database
	$db = $mongo->selectDB($db_name);

	return true;
}); 


h2("MailGun");

h3("Environment Variables");
validate("'MAILGUN_SMTP_PORT' exists", array_key_exists("MAILGUN_SMTP_PORT", $_SERVER) && $_SERVER["MAILGUN_SMTP_PORT"] <> "");
validate("'MAILGUN_SMTP_SERVER' exists", array_key_exists("MAILGUN_SMTP_SERVER", $_SERVER) && $_SERVER["MAILGUN_SMTP_SERVER"] <> "");
validate("'MAILGUN_SMTP_LOGIN' exists", array_key_exists("MAILGUN_SMTP_LOGIN", $_SERVER) && $_SERVER["MAILGUN_SMTP_LOGIN"] <> "");
validate("'MAILGUN_SMTP_PASSWORD' exists", array_key_exists("MAILGUN_SMTP_PASSWORD", $_SERVER) && $_SERVER["MAILGUN_SMTP_PASSWORD"] <> "");
validate("'MAILGUN_API_KEY' exists", array_key_exists("MAILGUN_API_KEY", $_SERVER) && $_SERVER["MAILGUN_API_KEY"] <> "");

h3("Service Test");
validate("Connection valid", function () {

	// Create and test connection to MailGun
	$transport = Swift_SmtpTransport::newInstance($_SERVER["MAILGUN_SMTP_SERVER"], $_SERVER["MAILGUN_SMTP_PORT"])
		->setUsername($_SERVER["MAILGUN_SMTP_LOGIN"])
		->setPassword($_SERVER["MAILGUN_SMTP_PASSWORD"])
	;
	$transport->start();
	$transport->stop();

	return true;
}); 


h2("MongoLAB");

h3("Environment Variables");
validate("'MONGOLAB_URI' exists", array_key_exists("MONGOLAB_URI", $_SERVER) && $_SERVER["MONGOLAB_URI"] <> ""); 

h3("Service Test", "h3");
validate("Connection valid", function () use (&$mongo) {

	// Open connection to MongoLab
	$mongo = new Mongo($_SERVER["MONGOLAB_URI"]);
	return $mongo->connected == 1;

}); 
validate("Database valid", function () use (&$mongo) {

	// Get database name
	preg_match('@/([^/]+?)$@i', $_SERVER["MONGOLAB_URI"], $matches);
	$db_name = $matches[1];

	// Connect to database
	$db = $mongo->selectDB($db_name);

	return true;
});
