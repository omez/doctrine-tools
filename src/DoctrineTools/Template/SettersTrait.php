<?php
namespace DoctrineTools\Template;

use DoctrineTools\Template\Utils;

/**
 * Virtual setter provider trait
 * 
 * @author Alexander Sergeychik
 * @version 0.1
 * @package DoctrineTools\Template
 */
trait SettersTrait {
	
	/**
	 * Default prefix for invokable setters
	 * @var string
	 */
	const INVOKABLE_SETTER_PREFIX = 'set';
	
	/**
	 * Returns name of setter method for $property
	 *
	 * @param string $property
	 * @return string
	 */
	protected function __getPropertySetterName($property) {
		return self::INVOKABLE_SETTER_PREFIX . Utils::property2method($property);
	}

	/**
	 * Invokes setter method for some $property
	 *
	 * @param string $property
	 * @return void
	 */
	protected function __invokePropertySetter($property, $value) {
		
		if (!$property) {
			throw new InvalidPropertyNameException("Property name can't be empty string");
		} 
		if ($property{0}=='_') {
			throw new ViolatedPropertyAccessException("Property ($property) prefixed by '_' are protected and write access has been violated");
		}
		
		if ($this->__hasPropertySetter($property)) {
			return call_user_func(array($this, $this->__getPropertySetterName($property)), $value);
		} elseif (property_exists($this, $property)) {
			return $this->$property = $value;
		} else {
			throw new InvalidPropertyNameException("No property or setter with name <{$property}> exists in ".get_class($this));
		}
		
		return $this;
	}
	
	/**
	 * Checks for setter method existance according to $property
	 *
	 * @param string $property
	 * @return boolean
	 */
	protected function __hasPropertySetter($property) {
		return method_exists($this, $this->__getPropertySetterName($property));
	}
	
	/**
	 * Additional setter method to access to properties through overrided setters
	 *
	 * @param string $property
	 * @param mixed $value
	 * @throws InvalidPropertyNameException
	 * @throws ViolatedAccessPropertyException
	 * @return mixed
	 */
	public function __set($property, $value) {
		return $this->__invokePropertySetter($property, $value);
	}
	
}