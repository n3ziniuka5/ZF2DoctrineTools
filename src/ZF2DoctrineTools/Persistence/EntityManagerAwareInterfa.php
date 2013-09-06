<?php
namespace ZF2DoctrineTools\Persistence;

/*
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 */

use Doctrine\ORM\EntityManager;

interface EntityManagerAwareInterface
{
    public function setEntityManager(EntityManager $entityManager);
}