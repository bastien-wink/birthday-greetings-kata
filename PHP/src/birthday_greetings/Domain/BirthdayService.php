<?php

namespace BirthdayGreetings\Domain;

class BirthdayService
{
    private EmployeeRepository $employeeRepository;
    private GreetingsSender $greetingsSender;

    public function __construct(EmployeeRepository $employeeRepository, GreetingsSender $greetingsSender)
    {
        $this->employeeRepository = $employeeRepository;
        $this->greetingsSender = $greetingsSender;
    }

    public function sendGreetings(XDate $xDate): void
    {
        foreach ($this->employeeRepository->findAll() as $employee) {
            if ($employee->isBirthday($xDate)) {
                $greeting = new Greeting(
                    $employee->getEmail(),
                    'Happy Birthday!',
                    str_replace('%NAME%', $employee->getFirstName(), 'Happy Birthday, dear %NAME%!'),
                );
                try {
                    $this->greetingsSender->send($greeting);
                } catch (\Exception $e) {
                    // Log error and continue with next employee
                    error_log("Error sending greetings: " . $e->getMessage());
                }
            }
        }
    }
}
