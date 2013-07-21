<?php
namespace ZF2DoctrineTools\Model;

use Zend\ServiceManager\ServiceManager;
/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Zend\ServiceManager\ServiceManager	$serviceManager
 * @property \Doctrine\ORM\EntityManager			$entityManager
 * @property Array									$config
 */
abstract class AbstractModel {
	
	protected $serviceManager;
	protected $entityManager;
	protected $config;
	
	protected $entityClass = null;
	protected $primaryColumn = null;
	
	public function __construct(ServiceManager $sm) {
		$this->serviceManager = $sm;
	}
	
	public function get($id) {
		if(!$this->entityClass || !$this->primaryColumn) {
			throw new \Exception('Entity class or primary column name is not specified');
		}
		$dql = "SELECT a FROM {$this->entityClass} a WHERE a.{$this->primaryColumn} = ?1";
		$query = $this->getEntityManager()->createQuery($dql);
		$query->setParameter(1, $id);
		return $query->getOneOrNullResult();
	}
	
	public function getList() {
		$dql = "SELECT a FROM {$this->entityClass} a ORDER BY a.{$this->primaryColumn} DESC";
		$query = $this->getEntityManager()->createQuery($dql);
		return $query->getResult();
	}
	
	public function delete($id) {
		$this->bulkDelete(array($id));
	}
	
	public function bulkDelete($ids) {
		$qb = $this->getEntityManager()->createQueryBuilder();
		$qb->delete($this->entityClass, 'a');
		$qb->where($qb->expr()->in("a.{$this->primaryColumn}", $ids));
		$query = $qb->getQuery();
		$query->execute();
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