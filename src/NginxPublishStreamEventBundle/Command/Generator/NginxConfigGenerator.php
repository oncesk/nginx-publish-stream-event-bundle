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
        $availableSub = array(
            'sub' => 'stream',
            'ev'  => 'eventsource',
            'lp'  => 'longpolling',
            'ws'  => 'websocket',
        );
        foreach ($configurations as $key=>$config)
        {
            $url = parse_url($config->getHost());
            $dump[$key]['host'] = $url['host'];
            $dump[$key]['protocol'] = $url['scheme'];
            $dump[$key]['port'] = $config->getPort();
            $dump[$key]['endpoint']['pub'] = $config->getEndpoint()->getPub();
            $dump[$key]['endpoint']['sub'] = $config->getEndpoint()->getSub();

            if (array_key_exists(ltrim($dump[$key]['endpoint']['sub'], '/'), $availableSub))
            {
                $dump[$key]['modes'] = $availableSub[$dump[$key]['endpoint']['sub']];
            }

            $dump[$key]['urlPrefixPublisher'] =  '/' . ltrim($config->getEndpoint()->getPub(), '/');
        }
        return 'var NginxConfig = ' . json_encode($dump, JSON_UNESCAPED_SLASHES);
    }

}