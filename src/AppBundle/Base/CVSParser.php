<?php
namespace AppBundle\Base;

use Symfony\Component\HttpFoundation\File\File;

class CVSParser
{
    public function parseFile(File $file)
    {
        $path = $file->getRealPath();
        if (($handle = fopen($path, 'r')) === false) {
            throw new \InvalidArgumentException();
        }

        $rows = [];

        while (($fields = fgetcsv($handle, 1000, ";")) !== false) {
            $rows[] = $fields;
        }

        return $rows;
    }
}