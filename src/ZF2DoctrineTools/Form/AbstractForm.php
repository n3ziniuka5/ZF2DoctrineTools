<?php
namespace ZF2DoctrineTools\Form;

use Doctrine\ORM\EntityManager;
use Zend\Form\Form;
use Zend\Mvc\I18n\Translator;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use ZF2DoctrineTools\Persistence\EntityManagerAwareInterface;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;
use ZF2DoctrineTools\Validator\UniqueValueValidator;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\ServiceManager\ServiceManager    $serviceManager
 * @property \Doctrine\ORM\EntityManager            $entityManager
 * @property \Zend\Mvc\I18n\Translator              $translator
 */
abstract class AbstractForm extends Form implements ServiceManagerAwareInterface, EntityManagerAwareInterface, TranslatorAwareInterface
{

    protected $serviceManager;
    protected $entityManager;
    protected $translator;

    public abstract function addFormInputs();

    public function addUniqueValidator($inputName, $entity, $field, $message, $omit = null)
    {
        $inputFilter = $this->getInputFilter();
        $input       = $inputFilter->get($inputName);
        $validator   = new UniqueValueValidator($entity, $field, $omit);
        $validator->setMessage($message);
        $input->getValidatorChain()->addValidator($validator);
    }

    protected function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    protected function getTranslator()
    {
        return $this->translator;
    }

    public function setTranslator(Translator $translator)
    {
        $this->translator = $translator;
    }

    protected function getEntityManager()
    {
        return $this->entityManager;
    }

    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

}