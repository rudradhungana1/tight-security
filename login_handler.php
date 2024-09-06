<?php
// Start session
session_start();

// Connect to database
require_once('db_config.php');

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get user input
  $username = mysqli_real_escape_string($conn, $_POST['login_username']);
  $password = $_POST['login_password'];
  $recaptcha_response = $_POST['g-recaptcha-response'];

  // Verify reCAPTCHA response
  $secret_key = "6Lc03jwlAAAAAGNaAq3yKiO-XHqQaTxaEMf1m_1P"; 
  $verify_response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secret_key}&response={$recaptcha_response}");
  $response_data = json_decode($verify_response);
  if (!$response_data->success) {
    $error = "Invalid reCAPTCHA response";
    $_SESSION['error'] = $error;
    header("location: login.php");
    exit;
  }

  // Check if the username is valid
  $query = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_assoc($result);
  $count = mysqli_num_rows($result);

  if ($count == 1) {
    // Check if the user has failed to log in 3 times within the last 5 minutes
    date_default_timezone_set('Asia/Kathmandu');
    $timestamp = date('Y-m-d H:i:s', time() - 300);

	// Get the timestamp of the last login attempt
	$query2 = "SELECT timestamp FROM login_attempts WHERE username = '$username' ORDER BY timestamp DESC LIMIT 1";
	$result2 = mysqli_query($conn, $query2);
	$row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	$last_login_attempt_timestamp = $row2['timestamp'];

	// Calculate the time difference between the last login attempt and the current time in minutes
	$last_login_attempt_time = strtotime($last_login_attempt_timestamp);
	$current_time = time();
	$time_difference_in_seconds = $current_time - $last_login_attempt_time;
	$time_difference_in_minutes = floor($time_difference_in_seconds / 60);


    $query1 = "SELECT COUNT(*) AS failed_attempts FROM login_attempts WHERE username = '$username' AND timestamp > '$timestamp'";
    $result1 = mysqli_query($conn, $query1);
    $row1 = mysqli_fetch_assoc($result1);
    $failed_attempts = $row1['failed_attempts'];

    if ($failed_attempts > 3 ) {
      // User has failed to log in 3 times within the last 5 minutes, prevent login for the next 5 minutes
      $remaining_time_in_seconds = 300 - $time_difference_in_seconds;
      $error = "Too many failed login attempts. Please try again in " . (floor($remaining_time_in_seconds/60)) . " minutes.";
      $_SESSION['error'] = $error;
      header("location: login.php?error=$error");
	  exit;
	}

		if(password_verify($password, $row['password'])) {
		// Password is correct, log the user in
		$_SESSION['success'] = $success_message;
		$_SESSION['username'] = $username;
		
		// Delete any failed login attempts for the same user from the database
		$query3 = "DELETE FROM login_attempts WHERE username='$username'";
		mysqli_query($conn, $query3);
		header("location: dashboard.php");

		exit;
		}
		else{
		// Password is incorrect, increment the failed attempt count
		$error = "Invalid Password";
		$attempts_query = "INSERT INTO login_attempts (username, timestamp) VALUES ('$username', NOW())";
		mysqli_query($conn, $attempts_query);
		header("location: login.php?error=$error");
		}

} else {
	// Username is invalid, display an error message
	$error = "Username Does not Exist";
	header("location: login.php?error=$error"); 
}
}

mysqli_close($conn);
?>
