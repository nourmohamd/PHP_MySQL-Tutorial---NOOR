<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require './phpmailer/autoload.php';
    $mail = new PHPMailer(true);
    try {
        // Server Settings
        $mail->isSMTP();
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = "abdonoor684@gmail.com";
        $mail->Password = "ssrr rxxj zjii sngj";
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // Content
        $mail->isHTML(true);
        $mail->CharSet = "UTF-8";
    }
    catch(Exception $e) {
        echo "There is an error " . $e;
    }
?>