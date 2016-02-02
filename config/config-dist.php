<?php
// Helpdesk configuration file
// This file should be renamed "config.php" in the config directory and updated with your environment details

// set to true or false to enable more verbose app errors
define('DEVELOPMENT_ENVIRONMENT',true);
// directory images submitted by the system will be saved into (set permissions on os)
define('UPLOAD_LOC', '/uploads/');
// name for the helpdesk to be used
define('CODENAME', 'Scaffold');
// company name used in various forms
define('COMPANY_NAME', 'Great Company PLC');
// company suffix used to postfix username for auto complete email etc
define('COMPANY_SUFFIX', 'domainnamehere.co.uk');
// allow local admin login
define('LOCALLOGIN', true);
// companys ldap server location for authentications
define('LDAP_SERVER', 'ldap://ldapserver.domainnamehere.co.uk');
// websever location and protocol you wish to connect using set to https for production
define('HELPDESK_LOC', 'http://' . $_SERVER['HTTP_HOST']);
// database location, schema, username and password
define('DB_LOC', 'localhost');
define('DB_SCHEMA', 'helpdesk');
define('DB_USER','username');
define('DB_PASSWORD','password');
// default timezone for server
date_default_timezone_set('Europe/London');
// helper items can be ignored
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DS', DIRECTORY_SEPARATOR);
