<?php

namespace App\Providers;

use Phalcon\Config;
use Phalcon\Mvc\Url as PhUrl;

class Url extends Provider
{

    protected $serviceName = 'url';

    public function register()
    {
        /**
         * @var Config $config
         */
        $config = $this->di->getShared('config');

        $this->di->setShared($this->serviceName, function () use ($config) {

            $url = new PhUrl();

            $url->setBaseUri($config->get('base_uri'));
            $url->setStaticBaseUri($config->get('static_base_uri'));

            return $url;
        });
    }

}