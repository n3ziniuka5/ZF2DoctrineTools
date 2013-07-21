<?php
namespace ZF2DoctrineTools\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceManager;
use ZF2DoctrineTools\Validator\UniqueValueValidator;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\ServiceManager\ServiceManager	$serviceManager
 * @property \Zend\I18n\Translator\Translator		$translator
 */
abstract class AbstractForm extends Form {
	
	protected $serviceManager;
	protected $translator;
	
	public function __construct(ServiceManager $sm, $name, array $options = array()) {
		$this->serviceManager = $sm;
		parent::__construct($name, $options);
	}
	
	public function addUniqueValidator($inputName, $table, $col, $primary, $message, $omit = null) {
		$inputFilter = $this->getInputFilter();
		$input = $inputFilter->get($inputName);
		$validator = new UniqueValueValidator($this->getServiceManager(), $table, $col, $primary, $omit);
		$validator->setMessage($message);
		$input->getValidatorChain()->addValidator($validator);
	}
	
	protected function getServiceManager() {
		return $this->serviceManager;
	}
	
	protected function getTranslator() {
		if(!$this->translator) {
			$this->translator = $this->getServiceManager()->get('translator');
		}
		return $this->translator;
	}
	
}