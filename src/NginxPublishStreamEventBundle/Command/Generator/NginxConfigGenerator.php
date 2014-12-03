<?php
namespace NginxPublishStreamEventBundle\Command\Generator;

/**
 * Class NginxChatConfigGenerator
 * @package NginxPublishStreamEventBundle\Command\Generator
 */
class NginxConfigGenerator
{

    public function generate($configurations)
    {
        return 'var NginxConfig = ' . json_encode($configurations);
    }

}