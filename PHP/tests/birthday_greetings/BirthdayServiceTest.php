<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\BirthdayService;
use BirthdayGreetings\Domain\Employee;
use BirthdayGreetings\Domain\XDate;
use PHPUnit\Framework\TestCase;

class BirthdayServiceTest extends TestCase
{
    private SpyGreetingsSender $sender;
    private BirthdayService $service;

    protected function setUp(): void
    {
        $this->sender = new SpyGreetingsSender();
        $this->service = new BirthdayService(new InMemoryEmployeeRepository([
            new Employee('John', 'Doe', '1982/10/08', 'john.doe@foobar.com'),
            new Employee('Mary', 'Ann', '1975/03/11', 'mary.ann@foobar.com'),
        ]), $this->sender);
    }

    public function testSendsGreetingsToEmployeesBornToday(): void
    {
        $this->service->sendGreetings(new XDate('2008/10/08'));

        $this->assertCount(1, $this->sender->sent);
        $this->assertSame('john.doe@foobar.com', $this->sender->sent[0]->email);
        $this->assertSame('Happy Birthday!', $this->sender->sent[0]->subject);
        $this->assertSame('Happy Birthday, dear John!', $this->sender->sent[0]->body);
    }

    public function testSendsNothingWhenNobodyIsBornToday(): void
    {
        $this->service->sendGreetings(new XDate('2008/01/01'));

        $this->assertCount(0, $this->sender->sent);
    }
}
