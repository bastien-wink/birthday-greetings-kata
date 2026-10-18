<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\BirthdayService;
use BirthdayGreetings\Domain\XDate;
use BirthdayGreetings\Infrastructure\FileEmployeeRepository;
use BirthdayGreetings\Infrastructure\SmtpGreetingsSender;


require_once __DIR__ . '/../../vendor/autoload.php';

class Main
{
    public static function main(): void
    {
        $service = new BirthdayService(
            new FileEmployeeRepository('employee_data.txt'),
            new SmtpGreetingsSender('maildev', 1025, 'sender@here.com'),
        );
        $service->sendGreetings(new XDate());
    }
}

if (php_sapi_name() === 'cli') {
    Main::main();
} 
