<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZF2DoctrineTools for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZF2DoctrineTools;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use ZF2DoctrineTools\Service\CacheService;
use ZF2DoctrineTools\Service\RegistryService;
use ZF2DoctrineTools\View\Helper\ThisRouteHelper;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 *
 */
class Module implements ConfigProviderInterface, ViewHelperProviderInterface, BootstrapListenerInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'thisRoute' => function () {
                    $e      = RegistryService::get('BootstrapEvent');
                    $helper = new ThisRouteHelper($e);
                    return $helper;
                },
            ],
        ];
    }

    public function onBootstrap(EventInterface $e)
    {
        $sm           = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();

        //For global ServiceManager Acccess
        RegistryService::set('ServiceManager', $sm);

        //Flush Doctrine transactions
        $eventManager->attach(
            'finish',
            function ($e) use ($sm) {
                $sm->get('Doctrine\ORM\EntityManager')->flush();
            }
        );

        //Bind bootstrap event to registry
        RegistryService::set('BootstrapEvent', $e);
    }

}
