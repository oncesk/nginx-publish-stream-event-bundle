<?php

namespace NginxPublishStreamEventBundle\AssetsPackage;

use ITM\MetronicBundle\AssetPackage\JQuery;

class NginxPublishStreamEventCommon extends \ITM\AssetManagerBundle\Package
{

    public function getName()
    {
        return 'nginx_publish_stream_event';
    }

    public function getJavascript()
    {
        return [
            'js/nginx_config.js',
            'bundles/nginxpublishstreamevent/js/pushstream.js',
            'bundles/nginxpublishstreamevent/js/nginx-publish-stream.js',
        ];
    }

    public function getDependencies()
    {
        return [
            JQuery::getClass()
        ];
    }

    public function getCss(){}

}