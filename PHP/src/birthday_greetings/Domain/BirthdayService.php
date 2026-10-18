<?php

namespace BirthdayGreetings\Domain;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class BirthdayService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function sendGreetings(XDate $xDate, string $smtpHost, int $smtpPort): void
    {
        foreach ($this->employeeRepository->findAll() as $employee) {
            if ($employee->isBirthday($xDate)) {
                $greeting = new Greeting(
                    $employee->getEmail(),
                    'Happy Birthday!',
                    str_replace('%NAME%', $employee->getFirstName(), 'Happy Birthday, dear %NAME%!'),
                );
                try {
                    $this->sendMessage($smtpHost, $smtpPort, 'sender@here.com', $greeting);
                } catch (\Exception $e) {
                    // Log error and continue with next employee
                    error_log("Error sending greetings: " . $e->getMessage());
                }
            }
        }
    }

    private function sendMessage(string $smtpHost, int $smtpPort, string $sender, Greeting $greeting): void
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $smtpHost;
            $mail->Port = $smtpPort;
            $mail->SMTPAuth = false;

            // Recipients
            $mail->setFrom($sender);
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
