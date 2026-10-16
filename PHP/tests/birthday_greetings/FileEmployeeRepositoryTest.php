<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\XDate;
use BirthdayGreetings\Infrastructure\FileEmployeeRepository;
use PHPUnit\Framework\TestCase;

class FileEmployeeRepositoryTest extends TestCase
{
    public function testReadsEveryEmployeeOfTheFile(): void
    {
        $repository = new FileEmployeeRepository('employee_data.txt');

        $employees = $repository->findAll();

        $this->assertCount(2, $employees);
        $this->assertEquals('John', $employees[0]->getFirstName());
        $this->assertEquals('john.doe@foobar.com', $employees[0]->getEmail());
        $this->assertTrue($employees[0]->isBirthday(new XDate('2008/10/08')));
    }

    public function testSkipsLinesWithAnInvalidDate(): void
    {
        $repository = new FileEmployeeRepository('tests/birthday_greetings/employee_data_invalid.txt');

        $employees = $repository->findAll();

        $this->assertCount(1, $employees);
        $this->assertEquals('John', $employees[0]->getFirstName());
    }
}
