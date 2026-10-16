<?php

namespace BirthdayGreetings;

use PHPUnit\Framework\TestCase;

class AcceptanceTest extends TestCase
{
    private const SMTP_PORT = 1025; // MailDev's default SMTP port
    private const API_URL = 'http://maildev:1080';
    private BirthdayService $birthdayService;

    protected function setUp(): void
    {
        $this->birthdayService = new BirthdayService(new FileEmployeeRepository('employee_data.txt'));
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

    public function testWillSendGreetingsWhenItsSomebodysBirthday(): void
    {
        $this->birthdayService->sendGreetings(
            new XDate('2008/10/08'),
            'maildev',
            self::SMTP_PORT
        );

        // Wait for email to be processed
        usleep(200_000);

        $emails = $this->getEmails();
        $this->assertCount(1, $emails, 'Expected exactly one email to be sent');

        $email = $emails[0];
        $this->assertEquals('Happy Birthday!', $email['subject']);
        $this->assertEquals('Happy Birthday, dear John!', trim($email['text']));
        $this->assertCount(1, $email['to']);
        $this->assertEquals('john.doe@foobar.com', $email['to'][0]['address']);
    }

    public function testWillNotSendEmailsWhenNobodysBirthday(): void
    {
        $this->birthdayService->sendGreetings(
            new XDate('2008/01/01'),
            'maildev',
            self::SMTP_PORT
        );

        // Wait for any potential emails to be processed
        usleep(200_000);

        $emails = $this->getEmails();
        $this->assertCount(0, $emails, 'Expected no emails to be sent');
    }
}
