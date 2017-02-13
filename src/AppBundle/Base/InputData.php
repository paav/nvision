<?php
namespace AppBundle\Base;

use AppBundle\Entity\Employee;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class InputData
{
    /**
     * @param int
     */
    protected $fieldsCount = 5;

    /**
     * @param string
     */
    protected $lastSeenFormat = 'd.m.Y';

    /**
     * @param string
     */
    protected $cityPlaceholder = 'Нет города';

    /**
     * @param CVSParser
     */
    protected $CVSParser = null;

    /**
     * @Assert\NotBlank(message="Выберите файл.")
     * @Assert\File(mimeTypes={ "text/plain" })
     */
    protected $file;

    /**
     * InputData constructor.
     */
    public function __construct()
    {
        $this->CVSParser = new CVSParser();
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param $file
     * @return $this
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @return Employee[]
     */
    public function toArrayOfEmployees()
    {
        $rows = $this->CVSParser->parseFile($this->getFile());
        $employees = [];

        foreach ($rows as $fields) {
            if (count($fields) !== $this->fieldsCount) {
                continue;
            }
            list($rawFullName, $position, $department, $rawCity, $rawLastSeen) = $fields;
            $fullName = $this->parseFullName($rawFullName);
            $lastSeen = $this->parseLastSeen($rawLastSeen);
            $city = $this->parseCity($rawCity);
            $employees[] = new Employee($fullName, $position, $department, $city, $lastSeen);
        }

        return $employees;
    }

    /**
     * @param $input
     * @return string
     */
    protected function parseFullName($input)
    {
        preg_match('/(?![0-9.\s]+).*/', $input, $marches);

        return $marches[0];
    }

    /**
     * @param $input
     * @return bool|\DateTime
     */
    protected function parseLastSeen($input)
    {
        $lastSeen = \DateTime::createFromFormat($this->lastSeenFormat, trim($input));

        return $lastSeen ?: null;
    }

    /**
     * @param $input
     * @return string
     */
    protected function parseCity($input)
    {
        return $input ?: $this->cityPlaceholder;
    }

    /**
     * @return mixed
     */
    public function getCityPlaceholder()
    {
        return $this->cityPlaceholder;
    }

    /**
     * @param mixed $cityPlaceholder
     */
    public function setCityPlaceholder($cityPlaceholder)
    {
        $this->cityPlaceholder = $cityPlaceholder;
    }
}