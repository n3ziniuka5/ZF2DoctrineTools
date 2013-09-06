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
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZF2DoctrineTools\Service\CacheService;
use ZF2DoctrineTools\Service\RegistryService;
use ZF2DoctrineTools\View\Helper\ThisRouteHelper;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 *
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface, BootstrapListenerInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [

        ];
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'thisRoute' => function ($sm) {
                    $locator  = $sm->getServiceLocator();
                    $registry = $locator->get('ZF2DoctrineTools\Service\Registry');
                    $e        = $registry->get('BootstrapEvent');
                    $helper   = new ThisRouteHelper($e);
                    return $helper;
                },
            )
        );
    }

    public function onBootstrap(EventInterface $e)
    {
        $sm           = $e->getApplication()->getServiceManager();
        $eventManager = $e->getApplication()->getEventManager();
        //Flush Doctrine transactions
        $eventManager->attach('finish', function ($e) use ($sm) {
            $sm->get('Doctrine\ORM\EntityManager')->flush();
        });

        //Bind bootstrap event to registry
        $registry = $sm->get('ZF2DoctrineTools\Service\Registry');
        $registry->set('BootstrapEvent', $e);
    }

}
