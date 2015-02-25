<?php

/** Configuration Variables **/

define('DEVELOPMENT_ENVIRONMENT',true);

define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('DS', DIRECTORY_SEPARATOR);
define('UPLOAD_LOC', '/uploads/');

define('CODENAME', 'helpdesk');
define('COMPANY_NAME', 'CLC');
define('COMPANY_SUFFIX', 'cheltenhamladiescollege.co.uk');
define('LDAP_SERVER', 'ldap://clcdc1.cheltenhamladiescollege.co.uk');
define('HELPDESK_LOC', 'http://' . $_SERVER['HTTP_HOST']);

define('DB_LOC', 'localhost');
define('DB_SCHEMA', 'helpdesk');
define('DB_USER','helpdesk');
define('DB_PASSWORD','helpdesk');

date_default_timezone_set('Europe/London');

