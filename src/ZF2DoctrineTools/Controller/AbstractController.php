<?php
namespace ZF2DoctrineTools\Controller;

use Doctrine\ORM\EntityManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\I18n\Translator;
use ZF2DoctrineTools\Persistence\EntityManagerAwareInterface;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\Mvc\I18n\Translator    $translator
 * @property Array                        $config
 * @property \Doctrine\ORM\EntityManager  $entityManager
 */
class AbstractController extends AbstractActionController implements TranslatorAwareInterface, EntityManagerAwareInterface
{
    protected $translator;
    protected $config;
    protected $entityManager;

    protected function getTranslator()
    {
        return $this->translator;
    }

    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    protected function getServiceManager()
    {
        return $this->getServiceLocator();
    }

    protected function getConfig()
    {
        if (!$this->config) {
            $this->config = $this->getServiceManager()->get('config');
        }
        return $this->config;
    }

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    protected function getEntityManager()
    {
        return $this->entityManager;
    }
}