<?php     
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include ('dbconnect.php');  
include_once('tcpdf_6_2_13/tcpdf.php');

if(!session_id()) {
    session_start();
}

if(isset($_GET['id'])) {
    $fid = $_GET["id"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$aqId = $_POST['AQ_id'];
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$emailbody = isset($_POST["emailContent"]) ? $_POST["emailContent"] : "";

// Query the database to get the file path based on AQ ID
$query = "SELECT AQ_path, O_id 
          FROM tb_advertisement_quotation 
          WHERE AQ_id = '$aqId'";
$result = mysqli_query($con, $query);


    if ($result && $row = mysqli_fetch_assoc($result)) {
        $attachmentPath = 'C:/xampp/htdocs/AKMaju/AKMaju/' . $row['AQ_path'];

        $quotation = $row['O_id'];

        //required files
        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';

        $mail = new PHPMailer(true);

        //Server settings
        $mail->isSMTP();                              //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
        $mail->SMTPAuth   = true;             //Enable SMTP authentication
        $mail->Username   = 'chuqingruoyun99@gmail.com';   //SMTP write your email
        $mail->Password   = 'zhngxzjpcgzpjssv';      //SMTP password
        $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
        $mail->Port       = 465;

        //Recipients
        $mail->setFrom($_POST["email"], 'AK MAJU'); // Sender Email and name
        $mail->addAddress($_POST["email"]);     //Add a recipient email  
        $mail->addReplyTo($_POST["email"]); // reply to sender email

        //Content
        $mail->isHTML(true);               //Set email format to HTML
        $mail->Subject = "Advertisement Quotation";   // email subject headings
        $mail->Body    = $emailbody; //email message
        $mail->AddAttachment($attachmentPath);

        // Success sent message alert
        $mail->send();
        $mail->SmtpClose();
        if ($mail->IsError()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        };
    }

}
mysqli_close($con);

header("Location: EditAOrder.php?id=$fid&o_id=$quotation");

?>
