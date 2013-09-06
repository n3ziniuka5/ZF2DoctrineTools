<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZF2DoctrineTools for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZF2DoctrineTools;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use ZF2DoctrineTools\View\Helper\ThisRouteHelper;
use ZF2DoctrineTools\Service\CacheService;
use ZF2DoctrineTools\Service\RegistryService;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 *
 */
class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig() {
    	return array(
    		'factories' => array(
    			'ZF2DoctrineTools\Service\Registry' => function ($sm) {
    				return new RegistryService();
    			},
    			'ZF2DoctrineTools\Service\CacheService' => function ($sm) {
    				return new CacheService($sm);
    			}
    		)
    	);
    }
    
	public function getViewHelperConfig() {
    	return array(
    		'factories' => array(
    			'thisRoute' => function($sm) {
    				$locator = $sm->getServiceLocator();
    				$registry = $locator->get('ZF2DoctrineTools\Service\Registry');
    				$e = $registry->get('BootstrapEvent');
    				$helper = new ThisRouteHelper($e);
    				return $helper;
    			},
    		)
    	);
    }
    
    public function onBootstrap(MvcEvent $e) {
    	$sm = $e->getApplication()->getServiceManager();
    	$eventManager        = $e->getApplication()->getEventManager();
    	//Flush Doctrine transactions
    	$eventManager->attach('finish', function($e) use ($sm) {
    		$sm->get('Doctrine\ORM\EntityManager')->flush();
    	});
    	
    	//Bind bootstrap event to registry
    	$registry = $sm->get('ZF2DoctrineTools\Service\Registry');
    	$registry->set('BootstrapEvent', $e);
    }
}
