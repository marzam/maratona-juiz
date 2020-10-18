<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require_once  'PHPMailer/Exception.php';
    require_once  'PHPMailer/PHPMailer.php';
    require_once  'PHPMailer/SMTP.php';
     
    echo 'Esqueceu a senha !?' . PHP_EOL;
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        $mail->Username = 'mzamith.prof@gmail.com'; // YOUR gmail email
        $mail->Password = 'mz1581041'; // YOUR gmail password
    
        // Sender and recipient settings
        $mail->setFrom('zamith.marcelo@gmail.com', 'Marcelo');
        $mail->addAddress('mzamith@ufrrj.br', 'Marcelo UFRRJ');
        //$mail->addReplyTo('example@gmail.com', 'Sender Name'); // to set the reply to
    
        // Setting the email content
        $mail->IsHTML(true);
        $mail->Subject = "Send email using Gmail SMTP and PHPMailer";
        $mail->Body = 'HTML message body. <b>Gmail</b> SMTP email body.';
        $mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';
    
        $mail->send();
        echo "Email message sent.";
    } catch (Exception $e) {
        echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
    }

?>
