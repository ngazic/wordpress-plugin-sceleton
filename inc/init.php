<?php
namespace Inc;

final class Init {

	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	static function getServices() {
		return [
			Base\EnqueueScriptsAndStyles::class
		];
	}

	/**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 * @return
	 */
	static function registerServices() {
		$services = self::getServices();
		foreach($services as $service) {
			echo $service;
			$service = self::instantiate($service);
			if(method_exists($service,'register')) {
				$service->register();
			}
		}
	}

	/**
	 * Initialize the class
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	static function instantiate($class) {
		return new $class();
	}
}