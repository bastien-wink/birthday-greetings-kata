<?php

namespace BirthdayGreetings\Infrastructure;

use BirthdayGreetings\Domain\Greeting;
use BirthdayGreetings\Domain\GreetingsSender;

class ConsoleGreetingsSender implements GreetingsSender
{
    public function send(Greeting $greeting): void
    {
        echo "To: {$greeting->email}\nSubject: {$greeting->subject}\n\n{$greeting->body}\n\n";
    }
}
