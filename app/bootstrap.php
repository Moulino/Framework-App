<?php

define('ROOT', dirname(dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
define('APP', ROOT.DS.'app');
define('CONTROLLER', APP.DS.'Controller');
define('MODEL', APP.DS.'Model');
define('VIEW', APP.DS.'View');
define('LOGS', ROOT.DS.'logs');
define('CACHE', ROOT.DS.'cache');
define('WEBROOT', ROOT.DS.'web');
define('VENDOR', ROOT.DS.'vendor');
define('FRAMEWORK', VENDOR.DS.'moulino'.DS.'framework'.DS.'src');
define('FRAMEWORK_VIEW', FRAMEWORK.DS.'Resources'.DS.'views');

require VENDOR.'/autoload.php';

define('FRAMEWORK_SERVICES', FRAMEWORK.DS.'Resources'.DS.'config'.DS.'services.php');
define('APP_SERVICES', APP.DS.'Resources'.DS.'config'.DS.'services.php');
define('APP_CONFIG', APP.DS.'Resources'.DS.'config'.DS.'parameters.php');

?>