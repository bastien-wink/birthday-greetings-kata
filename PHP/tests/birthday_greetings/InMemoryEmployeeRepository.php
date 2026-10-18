<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\Employee;
use BirthdayGreetings\Domain\EmployeeRepository;

class InMemoryEmployeeRepository implements EmployeeRepository
{
    /**
     * @param Employee[] $employees
     */
    public function __construct(private array $employees) {}

    public function findAll(): array
    {
        return $this->employees;
    }
}
