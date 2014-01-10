<?php


namespace Mrogelja\ConnectCompassBundle\Proxy;

/**
 * This class is aimed at getting the proxy related to project configuration
 *
 * Class ProxyHandler
 * @package Mrogelja\ConnectCompassBundle\Proxy
 */
class ProxyHandler {
    public function getProxyForSettings($settings)
    {
        switch ($proxyType = $settings['proxy_type']) {
            case 'propel':
                $propelSettings = $settings['connection']['propel'];
                return new PropelProxy(
                    $propelSettings['model'],
                    $propelSettings['variable_name_property'],
                    $propelSettings['variable_value_property'],
                    $propelSettings['variable_comment_property'],
                    $propelSettings['variable_updated_at_property']
                );
                break;
            default:
                throw new \Exception("Proxy type '$proxyType' not supported yet.");
        }
    }
}