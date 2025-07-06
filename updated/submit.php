<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: user_dash.html");
  exit();
}

// DB Connection
$conn = new mysqli("localhost", "root", "", "vastu_users");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user ID
$username = $_SESSION['username'];
$user_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
$user_query->bind_param("s", $username);
$user_query->execute();
$result = $user_query->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Get form data
$name = $_POST['name'];
$dob = $_POST['dob'];
$birthplace = $_POST['birthplace'];
$referred_by = $_POST['referred_by'];
$profession = $_POST['profession'];
$location = $_POST['location'];
$property_type = $_POST['property_type'];
$phone = $_POST['phone'];
$mode = $_POST['mode'];
$user_problem = $_POST['user_problem'];

$status = "pending";
$astrologer_msg = ""; // default empty
$date = date("Y-m-d");
$time = date("H:i:s");

// ✅ Process multiple selected products
$products = isset($_POST['products']) ? implode(", ", $_POST['products']) : "";

// Save to database
$stmt = $conn->prepare("INSERT INTO appointments 
  (user_id, name, dob, birthplace, referred_by, profession, location, property_type, phone, mode, user_problem, date, time, status, astrologer_msg, products, created_at) 
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

$stmt->bind_param("isssssssssssssss", 
  $user_id, $name, $dob, $birthplace, $referred_by, $profession,
  $location, $property_type, $phone, $mode, $user_problem, $date, $time,
  $status, $astrologer_msg, $products
);


if ($stmt->execute()) {
  // Save to appointments.txt (optional)
  $file_row = "$name | $dob | $birthplace | $referred_by | $profession | $location | $property_type | $phone | $mode | $user_problem | $date | $time | $status | $products\n";
  file_put_contents("appointments.txt", $file_row, FILE_APPEND);

  header("Location: thankyou.html");
  exit();
} else {
  echo "Error saving appointment: " . $stmt->error;
}
?>
