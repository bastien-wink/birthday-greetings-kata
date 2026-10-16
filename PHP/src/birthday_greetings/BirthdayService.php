<?php

namespace BirthdayGreetings;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class BirthdayService
{
    public function sendGreetings(string $fileName, XDate $xDate, string $smtpHost, int $smtpPort): void
    {
        $employeeRepository = new FileEmployeeRepository($fileName);
        foreach ($employeeRepository->findAll() as $employee) {
            if ($employee->isBirthday($xDate)) {
                $recipient = $employee->getEmail();
                $body = str_replace('%NAME%', $employee->getFirstName(), 'Happy Birthday, dear %NAME%!');
                $subject = 'Happy Birthday!';
                try {
                    $this->sendMessage($smtpHost, $smtpPort, 'sender@here.com', $subject, $body, $recipient);
                } catch (\Exception $e) {
                    // Log error and continue with next employee
                    error_log("Error sending greetings: " . $e->getMessage());
                }
            }
        }
    }

    private function sendMessage(string $smtpHost, int $smtpPort, string $sender, string $subject, string $body, string $recipient): void
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
            $mail->addAddress($recipient);

            // Content
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
        } catch (Exception $e) {
            throw new \RuntimeException("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 0, $e);
        }
    }
}
