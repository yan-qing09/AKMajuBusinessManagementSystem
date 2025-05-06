<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include('dbconnect.php');
$text = " ";

if (isset($_POST['femail']) && !empty($_POST['femail'])) {
    $femail = $_POST['femail'];
    $femail = filter_var($femail, FILTER_SANITIZE_EMAIL);
    $femail = filter_var($femail, FILTER_VALIDATE_EMAIL);

    if (!$femail) {
        $text = "Invalid email address";
        echo "<script type='text/javascript'>alert('{$text}');</script>";
    } else {
        $sql_query = "SELECT * FROM tb_user WHERE U_email='" . $femail . "'";
        $results = mysqli_query($con, $sql_query);
        $row = mysqli_num_rows($results);

        if ($row == 0) {
            $text = "Email address is not registered";
            echo "<script type='text/javascript'>alert('{$text}');</script>";
            exit(); 
        } else {
            $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
            $expDate = date("Y-m-d H:i:s", $expFormat);
            $key = md5(2418 * 2 . $femail);
            $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
            $key = $key . $addKey;
            mysqli_query($con, "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`)
                                VALUES ('" . $femail . "', '" . $key . "', '" . $expDate . "');");
            $text = "Password reset link is sent!";
            echo "<script type='text/javascript'>alert('{$text}');</script>";
            $output = '<p>Dear user,</p>';
            $output .= '<p>We received a request to reset your password. If you initiated this request, please click on the following link to reset your password:</p>';
            $output .= '<p><a href="https://www.akmaju.com/AKMaju/reset-password.php?key=' . $key . '&email=' . $femail . '&action=reset" target="_blank">Reset Your Password</a></p>';
            $output .= '<p>Please make sure to copy and paste the entire link into your browser.</p>';
            $output .= '<p>This link will expire in 1 day for security reasons.</p>';
            $output .= '<p>If you did not request a password reset, please disregard this email. Your password will remain unchanged.</p>';
            $output .= '<p>Thank you,</p>';
            $output .= '<p>Ak Maju Business Management System</p>';

            $body = $output;
            $subject = "Password Recovery - Ak Maju Business Management System";


            $email_to = $femail;
            require 'PHPMailer.php';
            require 'SMTP.php';
            require'Exception.php';
            $mail = new PHPMailer(true);
            $mail->IsSMTP();
            $mail->Host = 'mail.akmaju.com';
            $mail->SMTPAuth = true;
            $mail->Username = "akmajuco"; // Enter your email here
            $mail->Password = "JoeX0VS2:%C4"; //Enter your password here
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom("akmajuco@akmaju.com");
            $mail->addAddress($_POST["femail"]); 
            $mail->addReplyTo($_POST["femail"]);
            $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            if (!$mail->Send()) {
                include 'emailnotsent.php';
            } else {
                include 'emailsent.php';
            }
        }
    }
} else {
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en" style="background: url(&quot;assets/img/loginbg4.jpg&quot;) round;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Forgotten Password</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans&amp;display=swap">
    <link rel="stylesheet" href="assets/css/Filter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
    <link rel="stylesheet" href="assets/css/Ludens---1-Dark-mode-Index-Table-with-Search-Filters.css">
    <link rel="stylesheet" href="assets/css/sidebar-style4.css">
    <style>
        .form-control::placeholder {
        color: white; /* Change placeholder color to white */
        opacity:0.7;
        }
        .input{
            color:white;
        }
    </style>
</head>

<body class="bg-gradient-primary"style="background: rgba(78,115,223,0);">
    <section class="position-relative py-4 py-xl-5" style="margin-top: 68px;">
    <div class="container">
  <div class="row d-flex justify-content-center align-items-center" style="background: transparent;height: 500px;">
                <div class="col-md-6 col-xl-4 ">
                    <div class="card mb-5" style=" box-shadow: 0px 7px 29px 0px rgba(100, 100, 111, 0.8);background: linear-gradient(265deg, rgba(230,0,0,1) 0%, rgba(144,0,0,1) 30%, rgba(24,0,0,1) 100%);  ">
                        <div class="card-body d-flex flex-column align-items-center">
                            <div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4" style="background: url(&quot;assets/img/dogs/akmaju.jpg&quot;) round;border: 2px solid white;"></div>
                            <h4 style="color:white;font-weight: bold;margin-top:-10px;">Forgot Your Password?</h4>
                            <p style="color: rgba(255, 255, 255, 0.8);font-size:15px;text-align:center;">Just enter your email address below and we'll send you a link to reset your password.</p>
                                    <form class="user" action=""method="post">
                                        <div class="mb-3"><input class="form-control" type="email" name="femail" placeholder="Email Address" style="background:transparent;color:white;"></div>
                                    <div class="mb-3">
                                    <button class="btn btn-light d-block w-100" type="submit">Reset Password</button>
                                </div>
                                    </form>
                                    <div class="text-center"><a style="color:white;"class="small" href="index.php">Back to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="assets/js/Sidebar-Menu-sidebar.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
<?php
}
?>   
