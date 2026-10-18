<?php

namespace BirthdayGreetings\Domain;

final readonly class Greeting
{
    public function __construct(
        public string $email,
        public string $subject,
        public string $body,
    ) {}
}
