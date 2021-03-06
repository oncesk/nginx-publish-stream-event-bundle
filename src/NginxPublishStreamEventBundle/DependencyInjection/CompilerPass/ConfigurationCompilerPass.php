<?php
namespace NginxPublishStreamEventBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ConfigurationCompilerPass implements CompilerPassInterface {

	/**
	 * You can modify the container here before it is dumped to PHP code.
	 *
	 * @param ContainerBuilder $container
	 *
	 * @api
	 */
	public function process(ContainerBuilder $container)
	{
		if (!$container->hasDefinition('nginx_publish_stream_event.configuration')) {
			return;
		}

		$definition = $container->getDefinition('nginx_publish_stream_event.configuration');
		foreach ($container->findTaggedServiceIds('nginx.config') as $id => $attributes) {
			$definition->addMethodCall('addConfiguration', [$attributes[0]['key'], new Reference($id)]);
		}
    }
} 
