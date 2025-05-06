<?php
include('dbconnect.php');
if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
    $key = $_GET["key"];
    $email = $_GET["email"];
    $curDate = date("Y-m-d H:i:s");
    $query = mysqli_query($con,
        "SELECT * FROM `password_reset_temp` WHERE `key`='$key' AND `email`='$email';"
    );
    $row = mysqli_num_rows($query);
    $error=" ";
    if ($row == 0) {
        header("Location:invalid.php");
    } else {
        $row = mysqli_fetch_assoc($query);
        $expDate = $row['expDate'];
        if ($expDate >= $curDate) {
?>
<html data-bs-theme="light" lang="en"style="background: url(&quot;assets/img/loginbg4.jpg&quot;) round;" >
            <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>AK Maju</title>
    <link rel="icon" type="image/x-icon" href="akmaju.ico">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans&amp;display=swap">
    <link rel="stylesheet" href="assets/css/Filter.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Basic-icons.css">
    <link rel="stylesheet" href="assets/css/Ludens---1-Dark-mode-Index-Table-with-Search-Filters.css">
    <link rel="stylesheet" href="assets/css/sidebar-style4.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .form-control::placeholder {
        color: white; /* Change placeholder color to white */
        opacity:0.7;
        }
    </style>
</head>

<body class="bg-gradient-primary" style="background: rgba(78,115,223,0);">
    <section class="position-relative py-4 py-xl-5" style="margin-top: 68px;">
        <div class="container">
            <div class="row d-flex justify-content-center" style="background: transparent;">
                <div class="col-md-6 col-xl-4">
                    <div class="card mb-5" style=" box-shadow: 0px 7px 29px 0px rgba(255, 255, 255, 0.8);background: linear-gradient(265deg, rgba(230,0,0,1) 0%, rgba(144,0,0,1) 30%, rgba(24,0,0,1) 100%);  ">
                        <div class="card-body d-flex flex-column align-items-center">
                             <div class="bs-icon-xl bs-icon-circle bs-icon-primary bs-icon my-4" style="background: url(&quot;assets/img/dogs/akmaju.jpg&quot;) round;border: 2px solid white;"></div><h4 style="color:white;font-weight: bold;margin-top:-10px;">Reset Password</h4>
                             <p style="color: rgba(255, 255, 255, 0.9);font-size:13px;text-align:center;">Your password should be between 7 and 15 characters long with at least a digit and character.</p>
                            <form class="text-center" method="post" action=" " name="update">
                                <div class="mb-3"><input type="hidden" name="action" value="update" /><input class="form-control" pattern="(?=.*\d)(?=.*[a-zA-Z]).+" type="password" name="pass1" id="pass1"minlength="7"maxlength="15" placeholder="Enter New password" style="background:transparent;color:white;"required></div>
                                <div class="mb-3"><input class="form-control" pattern="(?=.*\d)(?=.*[a-zA-Z]).+" type="password" name="pass2" id="pass2" minlength="7" maxlength="15" placeholder="Re-Enter New password" style="background:transparent;color:white;"required><span id="passwordMatchError" style="color: white; font-size: 12px; font-style: italic;"></span></span></div>
                                
                                <input type="hidden" name="email" value="<?php echo $email;?>" />
                                <div class="mb-3">
                                    <button class="btn btn-light d-block w-100" type="submit" id="submitButton" disabled>Reset Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
  const pass1Input = document.getElementById('pass1');
  const pass2Input = document.getElementById('pass2');
  const passwordMatchError = document.getElementById('passwordMatchError');
  const submitButton = document.getElementById('submitButton');


  function checkPasswordMatch() {
    if (pass1Input.value !== pass2Input.value) {
      passwordMatchError.textContent = 'Passwords do not match';
    } else {
      passwordMatchError.textContent = '';
    }

    updateSubmitButton();
  }

  function updateSubmitButton() {
    submitButton.disabled = passwordMatchError.textContent !== '';
  }

   pass2Input.addEventListener('input', checkPasswordMatch);
</script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="assets/js/Sidebar-Menu-sidebar.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
<?php
        } else {
            $error = "Link Expired";
            header("Location:invalid.php");
        }
    }
}

if (isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {
    $error = "";
    $pass1 = mysqli_real_escape_string($con, $_POST["pass1"]);
    $pass2 = mysqli_real_escape_string($con, $_POST["pass2"]);
    $email = $_POST["email"];
    $curDate = date("Y-m-d H:i:s");
    if ($pass1 != $pass2) {
        $error .= "Passwords do not match. Both passwords should be the same.";
        echo "<script type='text/javascript'>alert('{$error}');</script>";
    }
        else {
        $hashedPassword = password_hash($pass1, PASSWORD_DEFAULT);
        mysqli_query($con,
            "UPDATE `tb_user` 
            SET `U_pwd`='$hashedPassword' 
            WHERE `U_email`='$email';"
        );

        mysqli_query($con, "DELETE FROM `password_reset_temp` WHERE `email`='$email';");
        
        $text2 = "Congratulations! Your password has been updated successfully.";
        echo "<script>
    var a= '$text2';
    alert(a);
    window.location.href = 'index.php';
</script>";
    }
}
?>
