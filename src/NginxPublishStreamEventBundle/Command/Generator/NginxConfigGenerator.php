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
            $url = parse_url($config->getHost());
            $dump[$key]['host'] = $url['host'];
            $dump[$key]['protocol'] = $url['scheme'];
            $dump[$key]['port'] = $config->getPort();
            $dump[$key]['endpoint']['pub'] = $config->getEndpoint()->getPub();
            $dump[$key]['endpoint']['sub'] = $config->getEndpoint()->getSub();
            $dump[$key]['modes'] = 'longpolling';
            $dump[$key]['urlPrefixLongpolling'] = '/sub';
        }
        return 'var NginxConfig = ' . json_encode($dump, JSON_UNESCAPED_SLASHES);
    }

}