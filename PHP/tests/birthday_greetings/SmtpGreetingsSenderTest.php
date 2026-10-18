<?php

namespace BirthdayGreetings;

use BirthdayGreetings\Domain\Greeting;
use BirthdayGreetings\Infrastructure\SmtpGreetingsSender;
use PHPUnit\Framework\TestCase;

class SmtpGreetingsSenderTest extends TestCase
{
    private const API_URL = 'http://maildev:1080';

    protected function setUp(): void
    {
        $this->deleteAllEmails();
    }

    private function deleteAllEmails(): void
    {
        file_get_contents(self::API_URL . '/email/all', false, stream_context_create([
            'http' => ['method' => 'DELETE']
        ]));
    }

    private function getEmails(): array
    {
        $response = file_get_contents(self::API_URL . '/email');
        return json_decode($response, true) ?? [];
    }

    public function testSendsTheGreetingByEmail(): void
    {
        $sender = new SmtpGreetingsSender('maildev', 1025, 'sender@here.com');

        $sender->send(new Greeting('john.doe@foobar.com', 'Happy Birthday!', 'Happy Birthday, dear John!'));
        usleep(200_000);

        $emails = $this->getEmails();
        $this->assertCount(1, $emails);
        $this->assertEquals('john.doe@foobar.com', $emails[0]['to'][0]['address']);
        $this->assertEquals('Happy Birthday!', $emails[0]['subject']);
        $this->assertEquals('Happy Birthday, dear John!', trim($emails[0]['text']));
    }
}
