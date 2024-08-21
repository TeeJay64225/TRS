<?php
// Start the session
session_start();

/**
 * Database Connection Helper
 */
function get_db_connection()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "trs";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	return $conn;
}

/**
 * User Authentication Helpers
 */

// Login Function
function login($phone_number, $password)
{
	$conn = get_db_connection();
	$stmt = $conn->prepare("SELECT id, password FROM users WHERE phone_number = ?");
	$stmt->bind_param("s", $phone_number);
	$stmt->execute();
	$stmt->store_result();

	if ($stmt->num_rows > 0) {
		$stmt->bind_result($user_id, $hashed_password);
		$stmt->fetch();
		if (password_verify($password, $hashed_password)) {
			$_SESSION['user_id'] = $user_id;
			return true;
		}
	}
	return false;
}

// Check if User is Logged In
function is_logged_in()
{
	return isset($_SESSION['user_id']);
}

// Logout Function
function logout()
{
	session_unset();
	session_destroy();
}

/**
 * Input Validation and Sanitization
 */
function sanitize_input($data)
{
	return htmlspecialchars(stripslashes(trim($data)));
}

function validate_email($email)
{
	return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * CSRF Protection
 */

// Generate CSRF Token
function generate_csrf_token()
{
	if (empty($_SESSION['csrf_token'])) {
		$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
	}
	return $_SESSION['csrf_token'];
}

// Validate CSRF Token
function validate_csrf_token($token)
{
	return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Flash Messages
 */
function set_flash_message($type, $message)
{
	$_SESSION['flash'][$type] = $message;
}

function get_flash_message($type)
{
	if (isset($_SESSION['flash'][$type])) {
		$message = $_SESSION['flash'][$type];
		unset($_SESSION['flash'][$type]);
		return $message;
	}
	return null;
}

/**
 * Password Hashing and Verification
 */
function hash_password($password)
{
	return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password($password, $hashed_password)
{
	return password_verify($password, $hashed_password);
}

/**
 * Redirect Function
 */
function redirect($url)
{
	header("Location: $url");
	exit();
}

/**
 * Miscellaneous Utilities
 */

// Generate a Random String
function generate_random_string($length = 10)
{
	return substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $length)), 0, $length);
}

/**
 * Error Handling
 */
function custom_error($error_message)
{
	error_log($error_message, 3, "/var/tmp/my-errors.log");
	echo "An error occurred. Please try again later.";
}
