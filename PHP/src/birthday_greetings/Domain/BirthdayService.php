<?php

namespace BirthdayGreetings\Domain;

use BirthdayGreetings\Infrastructure\SmtpGreetingsSender;

class BirthdayService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function sendGreetings(XDate $xDate, string $smtpHost, int $smtpPort): void
    {
        $sender = new SmtpGreetingsSender($smtpHost, $smtpPort, 'sender@here.com');
        foreach ($this->employeeRepository->findAll() as $employee) {
            if ($employee->isBirthday($xDate)) {
                $greeting = new Greeting(
                    $employee->getEmail(),
                    'Happy Birthday!',
                    str_replace('%NAME%', $employee->getFirstName(), 'Happy Birthday, dear %NAME%!'),
                );
                try {
                    $sender->send($greeting);
                } catch (\Exception $e) {
                    // Log error and continue with next employee
                    error_log("Error sending greetings: " . $e->getMessage());
                }
            }
        }
    }
}
