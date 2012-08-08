<?php
namespace DoctrineTools\Template;

use DoctrineTools\Template\Utils;

/**
 * Virtual getter provider trait
 * 
 * @author Alexander Sergeychik
 * @version 0.1
 * @package DoctrineTools\Template
 */
trait GettersTrait {
	
	/**
	 * Default prefix for invokable getters
	 * @var string
	 */
	static $INVOKABLE_GETTER_PREFIX = 'get';
	
	/**
	 * Returns name of getter method for $property
	 *
	 * @param string $property
	 * @return string
	 */
	protected function __getPropertyGetterName($property) {
		return self::$INVOKABLE_GETTER_PREFIX . Utils::property2method($property);
	}

	/**
	 * Invokes getter method for some $property
	 * 
	 * @param string $property
	 * @return mixed
	 */
	protected function __invokePropertyGetter($property) {
		
		if (!$property) {
			throw new InvalidPropertyNameException("Property name can't be empty string");
		} 
		if ($property{0}=='_') {
			throw new ViolatedPropertyAccessException("Property ($property) prefixed by '_' are protected and read access has been violated");
		}
		
		if ($this->__hasPropertyGetter($property)) {
			return call_user_func(array($this, $this->__getPropertyGetterName($property)));
		} elseif (property_exists($this, $property)) {
			return $this->$property;
		} else {
			throw new InvalidPropertyNameException("No property or getter with name <{$property}> exists in ".get_class($this));
		}
	}
	
	/**
	 * Checks for getter method existance according to $property
	 * 
	 * @param string $property
	 * @return boolean
	 */
	protected function __hasPropertyGetter($property) {
		return method_exists($this, $this->__getPropertyGetterName($property));
	}
	
	/**
	 * Additional getter method to access to properties through overrided getters
	 * 
	 * @param string $property
	 * @throws InvalidPropertyNameException
	 * @throws ViolatedAccessPropertyException
	 * @return mixed
	 */
	public function __get($property) {
		return $this->__invokePropertyGetter($property);
	}
	
}