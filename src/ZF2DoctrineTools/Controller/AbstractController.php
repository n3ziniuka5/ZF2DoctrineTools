<?php
namespace ZF2DoctrineTools\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\I18n\Translator;
use ZF2DoctrineTools\Translator\TranslatorAwareInterface;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\Mvc\I18n\Translator    $translator
 * @property Array                        $config
 */
class AbstractController extends AbstractActionController implements TranslatorAwareInterface
{
    protected $translator;
    protected $config;

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
}