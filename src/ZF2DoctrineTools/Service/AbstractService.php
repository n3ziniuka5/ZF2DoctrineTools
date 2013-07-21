<?php
namespace ZF2DoctrineTools\Service;
use Zend\ServiceManager\ServiceManager;
/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\ServiceManager\ServiceManager	$serviceManager
 * @property \Doctrine\ORM\EntityManager			$entityManager
 * @property \Zend\Db\Adapter\Adapter				$dbAdapter
 * @property \Zend\Db\Sql\Sql						$sql
 * @property Array									$config
 */
abstract class AbstractService {
	
	protected $serviceManager;
	protected $entityManager;
	protected $config;
	
	public function __construct(ServiceManager $sm) {
		$this->serviceManager = $sm;
	}
	
	protected function getServiceManager() {
		if(!$this->serviceManager) {
			throw new \Exception('Service manager has not been set in the constructor');
		}
		return $this->serviceManager;
	}
	
	protected function getEntityManager() {
		if(!$this->entityManager) {
			$this->entityManager = $this->getServiceManager()->get('Doctrine\ORM\EntityManager');
		}
		return $this->entityManager;
	}
	
	protected function getConfig() {
		if(!$this->config) {
			$this->config = $this->getServiceManager()->get('config');
		}
		return $this->config;
	}
}