<?php
namespace AppBundle\Base;

use Doctrine\ORM\EntityManager;

/**
 *
 */
abstract class BaseStore
{
    /**
     * @var EntityManager
     */
    protected $entityManager = null;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}
