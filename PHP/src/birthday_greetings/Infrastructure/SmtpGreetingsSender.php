<?php

namespace BirthdayGreetings\Infrastructure;

use BirthdayGreetings\Domain\Greeting;
use BirthdayGreetings\Domain\GreetingsSender;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SmtpGreetingsSender implements GreetingsSender
{
    public function __construct(
        private string $smtpHost,
        private int $smtpPort,
        private string $sender,
    ) {}

    public function send(Greeting $greeting): void
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $this->smtpHost;
            $mail->Port = $this->smtpPort;
            $mail->SMTPAuth = false;

            // Recipients
            $mail->setFrom($this->sender);
            $mail->addAddress($greeting->email);

            // Content
            $mail->isHTML(false);
            $mail->Subject = $greeting->subject;
            $mail->Body = $greeting->body;

            $mail->send();
        } catch (Exception $e) {
            throw new \RuntimeException("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 0, $e);
        }
    }
}
