<?php

namespace BirthdayGreetings\Domain;

interface GreetingsSender
{
    public function send(Greeting $greeting): void;
}
