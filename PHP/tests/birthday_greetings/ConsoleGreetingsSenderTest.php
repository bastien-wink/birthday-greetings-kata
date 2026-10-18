<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\Greeting;
use BirthdayGreetings\Infrastructure\ConsoleGreetingsSender;
use PHPUnit\Framework\TestCase;

class ConsoleGreetingsSenderTest extends TestCase
{
    public function testPrintsTheGreeting(): void
    {
        $this->expectOutputString("To: john.doe@foobar.com\nSubject: Happy Birthday!\n\nHappy Birthday, dear John!\n\n");

        (new ConsoleGreetingsSender())->send(
            new Greeting('john.doe@foobar.com', 'Happy Birthday!', 'Happy Birthday, dear John!'),
        );
    }
}
