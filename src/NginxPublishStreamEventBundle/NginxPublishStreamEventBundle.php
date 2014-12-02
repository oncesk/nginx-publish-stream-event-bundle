<?php
namespace NginxPublishStreamEventBundle;

use NginxPublishStreamEventBundle\DependencyInjection\CompilerPass\ConfigurationCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NginxPublishStreamEventBundle extends Bundle
{
	public function build(ContainerBuilder $container)
	{
		parent::build($container);
		$container->addCompilerPass(new ConfigurationCompilerPass());
	}
}
