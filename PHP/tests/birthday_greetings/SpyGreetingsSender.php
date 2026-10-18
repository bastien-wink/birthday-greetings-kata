<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\Greeting;
use BirthdayGreetings\Domain\GreetingsSender;

class SpyGreetingsSender implements GreetingsSender
{
    /** @var Greeting[] */
    public array $sent = [];

    public function send(Greeting $greeting): void
    {
        $this->sent[] = $greeting;
    }
}
