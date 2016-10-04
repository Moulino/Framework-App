<?php

require_once dirname(__FILE__)."/../app/bootstrap.php";

use Moulino\Framework\Config\Config;
use Moulino\Framework\Service\Config as ServiceConfig;
use Moulino\Framework\Service\Loader as ServiceLoader;
use Moulino\Framework\Console\Application;

Config::loadConfigFile(APP_CONFIG);

$frameworkServiceConfig = new ServiceConfig(FRAMEWORK_SERVICES);
$appServiceConfig 		= new ServiceConfig(APP_SERVICES);

$svcLoader = new ServiceLoader();
$svcLoader->load($frameworkServiceConfig);
$svcLoader->load($appServiceConfig);
$svcLoader->loadModels();

$container = $svcLoader->getContainer();

$app = new Application($container);
$app->run();

?>