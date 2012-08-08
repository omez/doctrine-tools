<?php
namespace DoctrineTools;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * DoctrineTools module
 * 
 * @author Alexander Sergeychik
 */
class Module implements ConfigProviderInterface, AutoloaderProviderInterface {
	
	/**
	 * {@inheritDoc}
	 */
	public function getConfig() {
		return (array)require __DIR__.'/../../config/module.config.php';
	}
	
	/**
	 * {@inheritDoc}
	 */
	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					'DoctrineTools' => __DIR__ . '/src/DoctrineTools',
				),
			),
		);
	}
	
}