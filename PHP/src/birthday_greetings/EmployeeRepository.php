<?php

namespace BirthdayGreetings;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function findAll(): array;
}
