<?php
session_start();
if(isset($_SESSION['signupsuccess'])) {
  $success = $_SESSION['signupsuccess'];
} 
if(isset($_GET['error'])) {
    $error = $_GET['error'];
  } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Validation</title>
    <link rel="stylesheet" href="css/login.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php
if(isset($_SESSION['signupsuccess'])) {
    echo "<script>alert('$success');</script>";
    unset($_SESSION['signupsuccess']);
}
?>   
</head>
<body>
<nav>
  <ul>
    <li><a href="#">Home</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Contact</a></li>
    <li style="float:right"><a href="register.php">Create a New Accoun ? </a></li>
  </ul>
</nav>
    <div class="container">
        <div class="form_box">
           <h1> Login </h1>
           <?php if(isset($_GET['error'])){ ?>
    		<div class="error-msg" > 
            <?php echo $error ?> </div>
		    <?php } ?>
            <form id="login" class="input_group" method="post" action="login_handler.php">

                <div class="form_div">
                    <input type="text" id="login_username" name="login_username" class="form_input" placeholder=" " autocomplete="off" required required >
                 <label for="" class="form_label">User Name</label>
                
                </div>
                <div class="form_div">
                    <input type="password" id="login_password" name="login_password" class="form_input" placeholder=" " autocomplete="off" required required>
                    <label for="" class="form_label">Password</label>
                </div>
                <div class="g-recaptcha" data-sitekey="6Lc03jwlAAAAAJ8jcy9P-82hQq4chU4aF_TfHXZK"></div>
                    <br>
                <button type="submit" class="submit_btn">Log in</button>
                <footer class="login-footer">
                    <p>Not registered yet ? <a href="register.php">Register Here</a></p>
                </footer>
            </form> 
        </div>
    </div>
    <script src="script.js"></script> 
 </body>

  </html>