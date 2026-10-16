<?php

namespace BirthdayGreetings\Domain;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function findAll(): array;
}
