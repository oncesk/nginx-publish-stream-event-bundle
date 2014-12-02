<?php
namespace NginxPublishStreamEventBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigurationDumper extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('nginx:stream:jsconfig')
			->setDescription('Dump nginx publish stream configuration into javascript files');
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$configurations = $this->getContainer()->get('nginx_publish_stream_event.configuration')->getConfigurations();
		$dir = $this->getContainer()->get('kernel')->getRootDir();
		$test = $configurations;
	}
}
