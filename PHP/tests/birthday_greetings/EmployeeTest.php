<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\Employee;
use BirthdayGreetings\Domain\XDate;
use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
{
    public function testBirthday(): void
    {
        $employee = new Employee("foo", "bar", "1990/01/31", "a@b.c");
        $this->assertTrue($employee->isBirthday(new XDate("2008/01/31")));
        $this->assertFalse($employee->isBirthday(new XDate("2008/01/30")));
        $this->assertFalse($employee->isBirthday(new XDate("2008/02/01")));
    }

    public function testBornOnFebruary29IsCelebratedOnFebruary28InNonLeapYears(): void
    {
        $employee = new Employee("foo", "bar", "1980/02/29", "a@b.c");
        $this->assertTrue($employee->isBirthday(new XDate("2015/02/28")));
        $this->assertFalse($employee->isBirthday(new XDate("2015/03/01")));
    }

    public function testBornOnFebruary29IsCelebratedOnFebruary29InLeapYears(): void
    {
        $employee = new Employee("foo", "bar", "1980/02/29", "a@b.c");
        $this->assertTrue($employee->isBirthday(new XDate("2016/02/29")));
        $this->assertFalse($employee->isBirthday(new XDate("2016/02/28")));
    }
}
