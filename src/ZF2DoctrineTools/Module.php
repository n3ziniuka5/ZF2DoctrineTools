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
use Zend\ModuleManager\Feature\ControllerProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use ZF2DoctrineTools\Persistence\EntityManagerAwareInterface;
use ZF2DoctrineTools\Service\CacheService;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;
use ZF2DoctrineTools\View\Helper\ThisRouteHelper;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 *
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface, BootstrapListenerInterface, ControllerProviderInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'initializers' => [
                function ($instance, $controllerManager) {
                    $serviceLocator = $controllerManager->getServiceLocator();
                    if ($instance instanceof TranslatorAwareInterface) {
                        $translator = $serviceLocator->get('translator');
                        $instance->setTranslator($translator);
                    }
                }
            ]
        ];
    }

    public function getServiceConfig()
    {
        return [
            'initializers' => [
                function ($instance, $serviceManager) {
                    if ($instance instanceof TranslatorAwareInterface) {
                        $translator = $serviceManager->get('translator');
                        $instance->setTranslator($translator);
                    }
                    if ($instance instanceof EntityManagerAwareInterface) {
                        $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
                        $instance->setEntityManager($entityManager);
                    }
                }
            ]
        ];
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories'    => array(
                'thisRoute' => function ($sm) {
                    $locator  = $sm->getServiceLocator();
                    $registry = $locator->get('ZF2DoctrineTools\Service\RegistryService');
                    $e        = $registry->get('BootstrapEvent');
                    $helper   = new ThisRouteHelper($e);
                    return $helper;
                },
            ),
            'initializers' => [
                function ($instance, $pluginManager) {
                    $serviceLocator = $pluginManager->getServiceLocator();
                    if ($instance instanceof TranslatorAwareInterface) {
                        $translator = $serviceLocator->get('translator');
                        $instance->setTranslator($translator);
                    }
                    if ($instance instanceof EntityManagerAwareInterface) {
                        $entityManager = $serviceLocator->get('Doctrine\ORM\EntityManager');
                        $instance->setEntityManager($entityManager);
                    }
                }
            ]
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
        $registry = $sm->get('ZF2DoctrineTools\Service\RegistryService');
        $registry->set('BootstrapEvent', $e);
    }

}
