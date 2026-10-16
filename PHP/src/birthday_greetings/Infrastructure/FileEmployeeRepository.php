<?php

namespace BirthdayGreetings\Infrastructure;

use BirthdayGreetings\Domain\Employee;
use BirthdayGreetings\Domain\EmployeeRepository;

class FileEmployeeRepository implements EmployeeRepository
{
    private string $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return Employee[]
     */
    public function findAll(): array
    {
        $handle = fopen($this->fileName, 'r');
        if ($handle === false) {
            throw new \RuntimeException("Could not open file: {$this->fileName}");
        }

        // Skip header
        fgetcsv($handle, 0, ',', '"', '\\');

        $employees = [];
        while (($data = fgetcsv($handle, 0, ',', '"', '\\')) !== false) {
            if (count($data) < 4) {
                continue; // Skip invalid lines
            }

            try {
                $employees[] = new Employee(trim($data[1]), trim($data[0]), trim($data[2]), trim($data[3]));
            } catch (\Exception $e) {
                // Log error and continue with next employee
                error_log("Error processing employee data: " . $e->getMessage());
            }
        }

        fclose($handle);
        return $employees;
    }
}
