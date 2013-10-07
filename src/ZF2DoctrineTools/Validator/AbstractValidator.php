<?php
namespace ZF2DoctrineTools\Validator;

use ZF2DoctrineTools\Service\RegistryService;

/**
 * Class AbstractValidator
 * @package ZF2DoctrineTools\Validator
 * @author  Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\ServiceManager\ServiceManager $serviceManager
 * @property \Doctrine\ORM\EntityManager         $entityManager
 */
abstract class AbstractValidator extends \Zend\Validator\AbstractValidator
{
    protected $serviceManager;
    protected $entityManager;

    protected function getServiceManager()
    {
        if (!$this->serviceManager) {
            $this->serviceManager = RegistryService::get('ServiceManager');
        }
        return $this->serviceManager;
    }

    protected function getEntityManager()
    {
        if (!$this->entityManager) {
            $this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
        }
        return $this->entityManager;
    }
}