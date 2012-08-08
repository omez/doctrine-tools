<?php
namespace DoctrineTools\Template;

use \InvalidArgumentException;

/**
 * Implements importable interface as trait.
 * 
 * @todo implement import conflicts strategies for array2array/scalar2array/array2scalar situations
 * 
 * @author Alexander Sergeychik
 * @package DoctrineTools\Template
 * @version 0.1-dev
 */
trait ImportTrait {
	
	/**
	 * Imports data into class/model
	 * 
	 * @param array|Traversable $data
	 */
	public function import($data) {
		
		if (!is_array() || !$data instanceof \Traversable) {
			throw new InvalidArgumentException('Import data is not an array or Traversable');
		}
		
		foreach ($data as $name=>$data) {
			if (!isset($this->$name)) continue;
			
			if (is_array($data) || $data instanceof \Traversable && $this->$name instanceof ImportTrait) {
				$this->$name->import($data);
			} else {
				$this->$name = $data;
			}
		}
		
		return $this;
	}
	
}