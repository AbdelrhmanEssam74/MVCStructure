<?php

namespace PROJECT\support;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class EmailHelper
{
  private $mailer;
  private $sender = "abdelrhmanroshdy8@gmail.com";

  public function __construct()
  {
    $this->mailer = new PHPMailer(true);

    // SMTP Configuration
    $this->mailer->isSMTP();
    $this->mailer->isHTML();
    $this->mailer->Host       = 'smtp.gmail.com';
    $this->mailer->SMTPAuth   = true;
    $this->mailer->Username   = $this->sender;
    $this->mailer->Password   = 'fqcdeummjgssevgc';
    $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mailer->Port       = 587;

    // Default sender
    $this->mailer->setFrom($this->sender, 'Abdelrhman');
  }

  public function sendEmail($to, $subject, $body)
  {
    try {
      $this->mailer->addAddress($to);
      $this->mailer->Subject = $subject;
      $this->mailer->Body    = $body;
      $this->mailer->CharSet = 'UTF-8';
      $this->mailer->isHTML(true);

      $this->mailer->send();
      return true;
    } catch (Exception $e) {
      return 'Message could not be sent. Mailer Error: ' . $this->mailer->ErrorInfo;
    }
  }
}
