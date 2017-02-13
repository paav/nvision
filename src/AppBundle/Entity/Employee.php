<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmployeeRepository")
 * @ORM\Table(name="employee")
 */
class Employee implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $lastSeenJSONFormat = 'Y-m-d';

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $fullName;

    /**
     * @ORM\Column(type="string")
     */
    protected $position;

    /**
     * @ORM\Column(type="string")
     */
    protected $department;

    /**
     * @ORM\Column(type="string")
     */
    protected $city;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    protected $lastSeen;

    public function __construct($fullName, $position, $department, $city, $lastSeen)
    {
        $this->fullName = $fullName;
        $this->position = $position;
        $this->department = $department;
        $this->city = $city;
        $this->lastSeen = $lastSeen;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Employee
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Employee
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return Employee
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set department
     *
     * @param string $department
     *
     * @return Employee
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Employee
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set lastSeen
     *
     * @param \DateTime $lastSeen
     *
     * @return Employee
     */
    public function setLastSeen($lastSeen)
    {
        $this->lastSeen = $lastSeen;

        return $this;
    }

    /**
     * Get lastSeen
     *
     * @return \DateTime
     */
    public function getLastSeen()
    {
        return $this->lastSeen;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'id' =>$this->getId(),
            'fullName' => $this->getFullName(),
            'lastSeen' => $this->serializeLastSeen($this->getLastSeen())
        ];
    }

    /**
     * @return mixed
     */
    public function getLastSeenJSONFormat()
    {
        return $this->lastSeenJSONFormat;
    }

    /**
     * @param mixed $lastSeenJSONFormat
     */
    public function setLastSeenJSONFormat($lastSeenJSONFormat)
    {
        $this->lastSeenJSONFormat = $lastSeenJSONFormat;
    }

    protected function serializeLastSeen($lastSeen)
    {
        return $lastSeen instanceof \DateTime ? $lastSeen->format($this->getLastSeenJSONFormat()) : null;
    }
}
