<?php
namespace ZF2DoctrineTools\Initializer;

use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF2DoctrineTools\Persistence\EntityManagerAwareInterface;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;


/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 */
class ControllerInitializer implements InitializerInterface
{
    public function initialize($instance, ServiceLocatorInterface $controllerManager)
    {
        $serviceManager = $controllerManager->getServiceLocator();
        if ($instance instanceof TranslatorAwareInterface) {
            $translator = $serviceManager->get('translator');
            $instance->setTranslator($translator);
        }
        if ($instance instanceof EntityManagerAwareInterface) {
            $entityManager = $serviceManager->get('Doctrine\ORM\EntityManager');
            $instance->setEntityManager($entityManager);
        }
    }
}