<?php
namespace ZF2DoctrineTools\Validator;

/**
 * @author Laurynas Tretjakovas(n3ziniuka5) <laurynas.tretjakovas@gmail.com>
 * @property \Doctrine\ORM\EntityManager    $entityManager
 */
class UniqueValueValidator extends AbstractValidator
{
    const IN_USE = 'inUse';

    protected $messageTemplates = [
        self::IN_USE => "%value% is already in use"
    ];

    protected $entity;
    protected $field;
    protected $omit;

    public function __construct($entity, $field, $omit = null)
    {
        parent::__construct();
        $this->entity = $entity;
        $this->field  = $field;
        $this->omit   = $omit;
    }

    public function isValid($value)
    {
        $this->setValue($value);
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('a.id');
        $qb->from($this->entity, 'a');
        $where = $qb->expr()->andX();
        $where->add($qb->expr()->eq('a.' . $this->field, ':value'));
        $qb->setParameter('value', $this->value);
        if ($this->omit) {
            $where->add($qb->expr()->neq('a.id', ':omit'));
            $qb->setParameter('omit', $this->omit);
        }
        $qb->where($where);
        $row = $qb->getQuery()->getArrayResult();
        if ($row) {
            $this->error(self::IN_USE);
            return false;
        }
        return true;
    }
}