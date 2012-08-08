<?php
/**
 * Configuration file for module.
 * 
 * @author Alexander Sergeychik
 */
return array (
	'doctrine'=>array(
		'configuration' => array(
			'orm_default' => array(
				'proxy_dir' => 'data/proxies',
				'proxy_namespace' => 'DoctrineProxy\\Proxy',
			),
		),
	),
);