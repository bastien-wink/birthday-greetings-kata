<?php

namespace BirthdayGreetings\Domain;

class XDate
{
    private \DateTimeImmutable $date;

    public function __construct(?string $yyyyMMdd = null)
    {
        if ($yyyyMMdd === null) {
            $this->date = new \DateTimeImmutable();
            return;
        }
        $date = \DateTimeImmutable::createFromFormat('Y/m/d', $yyyyMMdd);
        if ($date === false) {
            throw new \InvalidArgumentException("Invalid date format: $yyyyMMdd. Expected format: YYYY/MM/DD");
        }
        $this->date = $date;
    }

    public function getDay(): int
    {
        return (int) $this->date->format('d');
    }

    public function getMonth(): int
    {
        return (int) $this->date->format('m');
    }

    public function isSameDay(XDate $anotherDate): bool
    {
        return $anotherDate->getDay() === $this->getDay()
            && $anotherDate->getMonth() === $this->getMonth();
    }
}
