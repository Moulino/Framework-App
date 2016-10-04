<?php
require_once dirname(__FILE__)."/../app/bootstrap.php";

use Moulino\Framework\Config\Config;
use Moulino\Framework\Service\Config as ServiceConfig;
use Moulino\Framework\Service\Loader as ServiceLoader;

// loading the configuration ...
Config::loadConfigFile(APP_CONFIG);

$frameworkServiceConfig = new ServiceConfig(FRAMEWORK_SERVICES);
$appServiceConfig 		= new ServiceConfig(APP_SERVICES);

$svcLoader = new ServiceLoader();
$svcLoader->load($frameworkServiceConfig);
$svcLoader->load($appServiceConfig);
$svcLoader->loadModels();

$container = $svcLoader->getContainer();
$GLOBALS['service_container'] = $container;

$container->get('routes_loader')->load();
$container->get('translation_loader')->load();
$container->get('firewall_loader')->load();

$app = $container->get('kernel');
$app->run();

?>