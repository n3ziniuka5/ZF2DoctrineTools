<?php
namespace ZF2DoctrineTools\Service;
use Doctrine\ORM\EntityManager;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZF2DoctrineTools\Persistence\EntityManagerAwareInterface;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\ServiceManager\ServiceManager      $serviceManager
 * @property \Doctrine\ORM\EntityManager              $entityManager
 * @property Array                                    $config
 * @property \Zend\Mvc\I18n\Translator                $translator
 */
abstract class AbstractService implements ServiceManagerAwareInterface, EntityManagerAwareInterface, TranslatorAwareInterface
{

    protected $serviceManager;
    protected $entityManager;
    protected $config;
    protected $translator;

    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getTranslator()
    {
        return $this->translator;
    }

    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    protected function getConfig()
    {
        if (!$this->config) {
            $this->config = $this->getServiceManager()->get('config');
        }
        return $this->config;
    }
}