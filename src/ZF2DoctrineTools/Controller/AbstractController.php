<?php
namespace ZF2DoctrineTools\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\I18n\Translator;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\Mvc\I18n\Translator    $translator
 */
class AbstractController extends AbstractActionController implements TranslatorAwareInterface
{
    protected $translator;

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
}