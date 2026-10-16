<?php

namespace BirthdayGreetings;


require_once __DIR__ . '/../../vendor/autoload.php';

class Main
{
    public static function main(): void
    {
        $service = new BirthdayService(new FileEmployeeRepository('employee_data.txt'));
        $service->sendGreetings(new XDate(), 'maildev', 1025);
    }
}

if (php_sapi_name() === 'cli') {
    Main::main();
} 
