<?php
namespace ZF2DoctrineTools\View\Helper;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Helper\AbstractHelper;
use ZF2DoctrineTools\Persistence\EntityManagerAwareInterface;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;

/**
 * Class AbstractViewHelper
 * @package Travel\View\Helper
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\View\HelperPluginManager           $helperPluginManager
 * @property \Doctrine\ORM\EntityManager              $entityManager
 * @property \Zend\Mvc\I18n\Translator                $translator
 */
abstract class AbstractViewHelper extends AbstractHelper implements ServiceLocatorAwareInterface, EntityManagerAwareInterface, TranslatorAwareInterface
{
    protected $helperPluginManager;
    protected $entityManager;
    protected $translator;

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->helperPluginManager = $serviceLocator;
    }

    public function getServiceLocator()
    {
        return $this->helperPluginManager;
    }

    public function getServiceManager()
    {
        return $this->getServiceLocator()->getServiceLocator();
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
}