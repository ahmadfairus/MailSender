<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "library/PHPMailer.php";
require_once "library/Exception.php";
require_once "library/OAuth.php";
require_once "library/POP3.php";
require_once "library/SMTP.php";

// foreach ($_POST as $key => $value) {
//     echo "$key: $value\n";
// }

$headers = getallheaders();
$server_host = $_POST['host'];
$server_username = $_POST['username'];
$server_password = $_POST['password'];
$server_from = $_POST['mail_from'];
$server_fromname = $_POST['mail_fromname'];
if(isset($_POST['bodyHTML']) && !empty($_POST['bodyHTML'])){
    $server_bodyHTML = $_POST['bodyHTML'];
}else{
    $server_bodyHTML = false;
}
$server_source = $_POST['source'];

$mail_subject = $_POST['subject'];
$mail_to = $_POST['to'];
$mail_cc = $_POST['cc'];
$mail_bcc = $_POST['bcc'];
$mail_body = $_POST['body'];
$mail_bodysend = $mail_body;

if(isset($_FILES['body_file']['name']) && !empty($_FILES['body_file']['name'])) {
    $file_temp = $_FILES['body_file']['tmp_name'];
    $file_name = uniqid().'-'.$_FILES['body_file']['name'];
    $file_size = $_FILES['body_file']['size'];
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
    $file_path = 'uploads/'.$file_name;
    if(move_uploaded_file($file_temp, $file_path)){
        $body = file_get_contents($file_path);
        $mail_bodysend = $body;
    }
}

$mail = new PHPMailer(true);
$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = $server_host;
$mail->Username = $server_username;
$mail->Password = $server_password;
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom($server_from, $server_fromname);
$mail->isHTML($server_bodyHTML);

if(isset($_FILES['attachment']['name']) && !empty($_FILES['attachment']['name'])) {
    $attachment_temp = $_FILES['attachment']['tmp_name'];
    $attachment_name = $_FILES['attachment']['name'];
    $attachment_size = $_FILES['attachment']['size'];
    $attachment_ext = pathinfo($attachment_name, PATHINFO_EXTENSION);
    $attachment_path = "uploads/".$attachment_name;
    if(move_uploaded_file($attachment_temp, $attachment_path)){
        $mail->addAttachment($attachment_path);
    }
}

if(!empty($mail_subject) && !empty($mail_to)){
    $mail->Body = $mail_bodysend;
    $mail->Subject = $mail_subject;

    function cleanString($string){
        $string = trim($string);
        return preg_replace('/^[^a-zA-Z0-9]+|[^a-zA-Z0-9]+$/', '', $string);
    }

    $mail_to = cleanString($mail_to);
    $mail_toarray = explode(",", $mail_to);
    foreach($mail_toarray as $i){
        $mail->addAddress(trim($i));
    }
    if(isset($mail_cc) && !empty($mail_cc)){
        $mail_cc = cleanString($mail_cc);
        $mail_ccarray = explode(",", $mail_cc);
        foreach($mail_ccarray as $i){
            $mail->addCC(trim($i));
        }
    }
    if(isset($mail_bcc) && !empty($mail_bcc)){
        $mail_bcc = cleanString($mail_bcc);
        $mail_bccarray = explode(",", $mail_bcc);
        foreach($mail_bccarray as $i){
            $mail->addBCC(trim($i));
        }
    }

    try {
        $mail->send();
        header("Content-Type: application/json");
        $response = array(
            "status" => "Success",
            "Message" => "Pesan berhasil dikirim dengan subject => {$mail_subject} .",
        );
        $log_file = 'app.log';
        $timestamp = date('Y-m-d H:i:s');
        $log_line = "$timestamp - subject : $mail_subject - success send from : $server_source \n";
        file_put_contents($log_file,$log_line, FILE_APPEND);
        echo json_encode($response);
    } catch (Exception $e) {
        header("Content-Type: application/json");
        $response = array(
            "status" => "Error",
            "message" => $mail->ErrorInfo,
        );
        $log_file = 'app.log';
        $timestamp = date('Y-m-d H:i:s');
        $log_line = "$timestamp - $mail->ErrorInfo \n";
        file_put_contents($log_file,$log_line, FILE_APPEND);
        echo json_encode($response);
    }
}else{
    header("Content-Type: application/json");
    $response = array(
        "status" => "Error",
        "message" => "Data not completed");
    echo json_encode($response);
}
unlink($file_path);
unlink($attachment_path);

?>
