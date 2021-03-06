<?php
use Zend\ServiceManager\ServiceManager;

ini_set('display_errors', true);

/**
 * Before running of this script variable $serviceManager should be set
 *
 * @var $serviceManager Zend\ServiceManager\ServiceManager
 */
$serviceManager = include __DIR__.'/doctrine-boot.php';



echo "Loading CLI environment...\n";

if (!isset($serviceManager)) {
	throw new RuntimeException('Service manager not set');
} elseif (!$serviceManager instanceof ServiceManager) {
	throw new RuntimeException('Service manager registered but not instance of ServiceManager');
}


/* @var $cli \Symfony\Component\Console\Application */
$cli = $serviceManager->get('doctrine.cli');

// registering migrations.xml to all migrations:* commands
$commands = $cli->all('migrations');

// Set default migrations configuration option to migrations.xml location 
foreach ($commands as $command) {
	$option = $command->getDefinition()->getOption('configuration');
	$option->setDefault('config/migrations.xml');
}

$cli->run();

