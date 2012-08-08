<?php
namespace DoctrineTools\Template;

/**
 * Full virtual property access trait.
 * 
 * @author Alexander Sergeychik
 * @version 0.1
 * @package DoctrineTools\Template
 */
trait AccessibleTrait {
	
	use GettersTrait, SettersTrait, ExistanceTrait;
	
}