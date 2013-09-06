<?php
namespace ZF2DoctrineTools\Persistence;
use Doctrine\ORM\EntityManager;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 */

interface EntityManagerAwareInterface
{
    public function setEntityManager(EntityManager $entityManager);
}