<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

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
    <link rel="shortcut icon" type="image/jpg" href="assets/img/dogs/akmaju.jpg"/>
</head>

<body class="bg-gradient-primary" style="background: rgb(222,203,202);">
    <div class="container">
        <!-- Your existing HTML structure -->
        <!-- ... -->
        <?php
        include('dbconnect.php');
        
        if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
            $key = $_GET["key"];
            $email = $_GET["email"];
            $curDate = date("Y-m-d H:i:s");
            $query = mysqli_query($con, "SELECT * FROM `password_reset_temp` WHERE `key`='" . $key . "' AND `email`='" . $email . "';");
            $row = mysqli_num_rows($query);
            
            if ($row == 0) {
                echo '<h2>Invalid Link</h2>
                    <p>The link is invalid/expired. Either you did not copy the correct link
                    from the email, or you have already used the key in which case it is 
                    deactivated.</p>
                    <p><a href="https://www.allphptricks.com/forgot-password/index.php">Click here</a> to reset password.</p>';
            } else {
                $row = mysqli_fetch_assoc($query);
                $expDate = $row['expDate'];
                if ($expDate >= $curDate) {
        ?>
                    <form method="post" action="" name="update">
                        <input type="hidden" name="action" value="update" />
                        <br /><br />
                        <label><strong>Enter New Password:</strong></label><br />
                        <input type="password" name="pass1" maxlength="15" required />
                        <br /><br />
                        <label><strong>Re-Enter New Password:</strong></label><br />
                        <input type="password" name="pass2" maxlength="15" required />
                        <br /><br />
                        <input type="hidden" name="femail" value="<?php echo $email; ?>" />
                        <input type="submit" value="Reset Password" />
                    </form>
        <?php
                } else {
                    echo "<h2>Link Expired</h2>
                    <p>The link is expired. You are trying to use the expired link which is valid only 24 hours (1 day after request).</p>";
                }
            }
        }
        
        if (isset($_POST["femail"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
            $error = "";
            $pass1 = mysqli_real_escape_string($con, $_POST["pass1"]);
            $pass2 = mysqli_real_escape_string($con, $_POST["pass2"]);
            $email = $_POST["femail"];
            
            if ($pass1 != $pass2) {
                $error .= "<p>Passwords do not match, both passwords should be the same.</p>";
            }
            
            if ($error == "") {
                $pass1 = md5($pass1);
                mysqli_query($con, "UPDATE `tb_user` SET `U_pwd`='" . $pass1 . "' WHERE `U_email`='" . $email . "';");
                mysqli_query($con, "DELETE FROM `password_reset_temp` WHERE `email`='" . $email . "';");
                echo '<div class="success"><p>Congratulations! Your password has been updated successfully.</p>
                    <p><a href="https://www.allphptricks.com/forgot-password/login.php">Click here</a> to Login.</p></div>';
            } else {
                echo '<div class="error">' . $error . '</div>';
            }
        }
        ?>
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

