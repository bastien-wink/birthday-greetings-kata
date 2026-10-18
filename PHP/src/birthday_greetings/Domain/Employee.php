<?php

namespace BirthdayGreetings\Domain;

class Employee
{
    private XDate $birthDate;

    public function __construct(
        private string $firstName,
        private string $lastName,
        string $birthDate,
        private string $email,
    ) {
        $this->birthDate = new XDate($birthDate);
    }

    public function isBirthday(XDate $today): bool
    {
        // Employees born on February 29 are celebrated on February 28 in non-leap years
        if ($this->isBornOnFebruary29() && !$today->isLeapYear()) {
            return $today->getMonth() === 2 && $today->getDay() === 28;
        }
        return $today->isSameDay($this->birthDate);
    }

    private function isBornOnFebruary29(): bool
    {
        return $this->birthDate->getMonth() === 2 && $this->birthDate->getDay() === 29;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }
}
