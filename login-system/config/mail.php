<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . "/../vendor/autoload.php";

function sendOTPEmail($email, $name, $otp)
{
    $mail = new PHPMailer(true);

    try {




        // Gmail SMTP
        $mail->isSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;

        // Gmail account
        $mail->Username = "chita.agenticai@gmail.com";

        // Gmail App Password
        $mail->Password = "cgcl ylta fnjw jrsj";

        // Gmail TLS
        $mail->SMTPSecure =
            PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;

        // Sender
        $mail->setFrom(
            "YOUR_GMAIL@gmail.com",
            "PHP Login System"
        );

        // Recipient
        $mail->addAddress(
            $email,
            $name
        );

        // Email format
        $mail->isHTML(true);

        $mail->Subject =
            "Your Login Verification Code";

        $mail->Body = "
            <h2>Login Verification</h2>

            <p>
                Hello <strong>" .
                htmlspecialchars($name) .
                "</strong>,
            </p>

            <p>
                Your verification code is:
            </p>

            <h1 style='
                font-size: 32px;
                letter-spacing: 10px;
            '>
                {$otp}
            </h1>

            <p>
                This code expires in
                <strong>5 minutes</strong>.
            </p>

            <p>
                If you did not attempt to login,
                please ignore this email.
            </p>
        ";

        $mail->AltBody =
            "Your login verification code is {$otp}. " .
            "This code expires in 5 minutes.";

        // Send email
        $mail->send();

        return true;

    } catch (Exception $e) {

        // Log error to Apache/PHP error log
        error_log(
            "PHPMailer Error: " .
            $mail->ErrorInfo
        );

        return false;
    }
}