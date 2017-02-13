<?php
namespace AppBundle\Base;

/**
 * 
 */
class EmployeeStore extends BaseStore
{
    /**
     * @var int
     */
    protected $bulkSize = 20;

    /**
     * @param array $employees
     */
    public function bulkInsert(array $employees)
    {
        $em = $this->entityManager;
        $i = 0;

        foreach ($employees as $employee) {
            $em->persist($employee);

            if (($i % $this->bulkSize) === 0) {
                $em->flush();
                $em->clear();
            }

            $i++;
        }

        $em->flush();
        $em->clear();
    }

    /**
     * @param int $bulkSize
     * @return EmployeeStore
     */
    public function setBulkSize($bulkSize)
    {
        $this->bulkSize = $bulkSize;
        return $this;
    }

    /**
     * @return int
     */
    public function getBulkSize()
    {
        return $this->bulkSize;
    }
}