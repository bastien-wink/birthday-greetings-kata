<?php

namespace BirthdayGreetings;

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
        return $today->isSameDay($this->birthDate);
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
