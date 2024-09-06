<?php
session_start();
// connect to the database
require_once('db_config.php');

// Verify reCAPTCHA response
$recaptcha_response = $_POST['g-recaptcha-response'];
$secret_key = "6Lc03jwlAAAAAGNaAq3yKiO-XHqQaTxaEMf1m_1P"; 
$verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$recaptcha_response}");
$response_data = json_decode($verify_response);
if (!$response_data->success) {
	$error = "Invalid reCAPTCHA response";
	header("location: register.php");
	exit;
}

// check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// get the form data
	$email = $_POST["email_input"];
	$username = $_POST["user_name_input"];
	$password = $_POST["password_input"];
	$confirm_password = $_POST["confirm_password_input"];
	$registration_date = date('Y-m-d H:i:s');
	
	// check if the username is already registered
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$error = "Error: " . $sql . "<br>" . mysqli_error($conn);
		$_SESSION['error'] = $error;
		exit;
	}
	
	if (mysqli_num_rows($result) > 0) {
		$error =  "User Name is already Taken. Please use a different username.";
		$_SESSION['error'] = $error;
		header("location: register.php?error=$error");
		exit;
	}

	// check if the email is already registered
	$sql2 = "SELECT * FROM users WHERE email = '$email'";
	$result2 = mysqli_query($conn, $sql2);
	if (!$result2) {
		$error = "Error: " . $sql . "<br>" . mysqli_error($conn);
		exit;
	}
	
	if (mysqli_num_rows($result2) > 0) {
		$error = "This email is already registered. Use another.";
		$_SESSION['error'] = $error;
		header("location: register.php?error=$error");
		exit;
	}



	// check if the passwords match
	if ($password != $confirm_password) {
		$error = "Sorry, the passwords do not match. Please try again.";
		$_SESSION['error'] = $error;
		header("location: login.php?error=$error");
		exit;
	}
       // hash the password for security
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
	
       // insert the user's details into the database
         $sql = "INSERT INTO users (email, username, password, created_at) 
          VALUES ('$email', '$username', '$hashed_password', '$registration_date')";
         if (mysqli_query($conn, $sql)) {
	     $_SESSION['signupsuccess'] = "Successfully registered as a user";
	     header("location: login.php");
       } else {
	echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }



	// close the database connection
	mysqli_close($conn);
}
?>
