<?php
namespace ZF2DoctrineTools\Controller;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\I18n\Translator\Translator	$translator
 */
class AbstractController extends AbstractActionController
{
	protected $translator;
	
	protected function getTranslator() {
		if(!$this->translator) {
			$this->translator = $this->getServiceManager()->get('translator');
		}
		return $this->translator;
	}
}