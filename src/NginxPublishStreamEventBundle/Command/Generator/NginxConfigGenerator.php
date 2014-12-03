<?php
namespace NginxPublishStreamEventBundle\Command\Generator;

/**
 * Class NginxChatConfigGenerator
 * @package NginxPublishStreamEventBundle\Command\Generator
 */
class NginxConfigGenerator
{
    /**
     * @param \NginxPublishStream\Stream\Configuration[] $configurations
     * @return string
     */
    public function generate($configurations)
    {
        $dump = array();
        foreach ($configurations as $key=>$config) {
            $dump[$key]['host'] = $config->getHost();
            $dump[$key]['port'] = $config->getPort();
            $dump[$key]['endpoint']['pub'] = $config->getEndpoint()->getPub();
            $dump[$key]['endpoint']['sub'] = $config->getEndpoint()->getSub();
        }
        return 'var NginxConfig = ' . json_encode($dump);
    }

}