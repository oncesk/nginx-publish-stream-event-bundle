<?php
namespace NginxPublishStreamEventBundle\Service;

class Configuration {

	/**
	 * @var \NginxPublishStream\Stream\Configuration[]
	 */
	protected $configurations = array();

	/**
	 * @param string $alias
	 * @param \NginxPublishStream\Stream\Configuration $configuration
	 */
	public function addConfiguration($alias, \NginxPublishStream\Stream\Configuration $configuration) {
		$this->configurations[$alias] = $configuration;
	}

	/**
	 * @return \NginxPublishStream\Stream\Configuration[]
	 */
	public function getConfigurations() {
		return $this->configurations;
	}
} 
