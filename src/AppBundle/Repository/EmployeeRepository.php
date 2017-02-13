<?php
namespace AppBundle\Repository;

use AppBundle\Entity\Employee;
use AppBundle\Enum\EmployeeCategory;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 *
 */
class EmployeeRepository extends EntityRepository
{
    /**
     * @param string $city
     * @return QueryBuilder
     */
    protected function findAllOfRegionalNetworkRepairingByCityQuery($city)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
            ->from('AppBundle:Employee', 'e')
            ->where("e.position LIKE '%монтажник%' OR e.position LIKE '%специалист%'")
            ->andWhere("
                e.department LIKE '%участок%' 
                OR e.department LIKE '%ремонта районных сетей%'
                OR e.department LIKE '%аварийно-восстановительных работ%'
            ")
            ->andWhere("e.city LIKE '%$city%'");

        return $qb;
    }

    /**
     * @param null $city
     * @param bool $groupByCity
     * @return array
     */
    public function findAllOfRegionalNetworkRepairingByCity($city = null, $groupByCity = false)
    {
        $qb = $this->findAllOfRegionalNetworkRepairingByCityQuery($city);
        $qb = $groupByCity ? $qb->groupBy('e.city') : $qb;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $city
     * @return QueryBuilder
     */
    protected function findAllOfClientServiceByCityQuery($city)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
            ->from('AppBundle:Employee', 'e')
            ->where("
                e.position LIKE '%монтажник%'
                OR e.position LIKE '%специалист%'
                OR e.position LIKE '%техник%' 
                OR e.position LIKE '%сервис-инженер%'
            ")
            ->andWhere("
                e.department LIKE '%Группа обслуживания сети%'
                OR e.department LIKE '%Группа клиентских сервисов%' 
                OR e.department LIKE '%Участок%'
            ")
            ->andWhere("e.city LIKE '%$city%'");

        return $qb;
    }

    /**
     * @param null $city
     * @param bool $groupByCity
     * @return Employee[]
     */
    public function findAllOfClientServiceByCity($city = null, $groupByCity = false)
    {
        $qb = $this->findAllOfClientServiceByCityQuery($city);
        $qb = $groupByCity ? $qb->groupBy('e.city') : $qb;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param string $city
     * @return QueryBuilder
     */
    protected function findAllOfClientServiceHeadsByCityQuery($city)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('e')
            ->from('AppBundle:Employee', 'e')
            ->where("e.position LIKE '%руководитель%'")
            ->andWhere("
                e.department LIKE '%Группа обслуживания сети%' 
                OR e.department LIKE '%Группа клиентских сервисов%' 
                OR e.department LIKE '%Участок%'
            ")
            ->andWhere("e.city LIKE '%$city%'");

        return $qb;
    }

    /**
     * @param null $city
     * @param bool $groupByCity
     * @return Employee[]
     */
    public function findAllOfClientServiceHeadsByCity($city = null, $groupByCity = false)
    {
        $qb = $this->findAllOfClientServiceHeadsByCityQuery($city);
        $qb = $groupByCity ? $qb->groupBy('e.city') : $qb;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $categories
     * @return string[]
     */
    public function findCitiesSplitByCategories($categories)
    {
        $employeeColumns = [];

        foreach ($categories as $category) {
            $method = $this->getMethodByEmployeeCategory($category);
            $employeeColumns[] = $this->$method(null, true);
        }

        $columnSizes = [];

        foreach ($employeeColumns as $employeeColumn) {
            $columnSizes[] = count($employeeColumn);
        }

        $maxSize = max($columnSizes);
        $columnsCount = count($employeeColumns);
        $cities = [];

        for ($i = 0; $i < $maxSize; $i++) {
            for ($j = 0; $j < $columnsCount; $j++) {
                if (isset($employeeColumns[$j][$i])) {
                    /** @var Employee $employee */
                    $employee = $employeeColumns[$j][$i];
                    $cities[$i][$j] = $employee->getCity();
                } else {
                    $cities[$i][$j] = null;
                }
            }
        }

        return $cities;
    }

    /**
     * @param int $category
     * @param string $city
     * @return Employee[]
     */
    public function findByCategoryAndCity($category, $city)
    {
        $method = $this->getMethodByEmployeeCategory($category);
        $employees = $this->$method($city);

        return $employees;
    }

    /**
     * @param int $category
     * @return string
     */
    protected function getMethodByEmployeeCategory($category)
    {
        switch ($category) {
            case EmployeeCategory::RegionalNetworkRepairing:
                $method = 'findAllOfRegionalNetworkRepairingByCity';
                break;
            case EmployeeCategory::ClientService:
                $method = 'findAllOfClientServiceByCity';
                break;
            case EmployeeCategory::ClientServiceHeads:
                $method = 'findAllOfClientServiceHeadsByCity';
                break;
            default:
                throw new \InvalidArgumentException('Unsupported EmployeeCategory.');
        }

        return $method;
    }
}