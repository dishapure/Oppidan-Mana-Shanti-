<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: user_dash.html");
  exit();
}
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "vastu_users");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT astrologer_msg, products, created_at FROM appointments WHERE user_id = ? ORDER BY created_at DESC");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    if (!empty($row['astrologer_msg']) || !empty($row['products'])) {
      $messages[] = $row;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Messages</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f7f3fb;
      margin: 0;
      padding: 20px;
      color: #3c1c56;
    }

    .page-heading {
      text-align: center;
      font-size: 36px;
      font-weight: 700;
      margin-bottom: 40px;
      background: linear-gradient(90deg, #6d3c8f, #b38bff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-shadow: 1px 1px 2px rgba(109, 60, 143, 0.2);
      letter-spacing: 1px;
      animation: fadeIn 1s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .message-box {
      width: 80%;
      margin: auto;
      background-color: white;
      border-radius: 15px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
    }

    .message-box:hover {
      background-color: #fff8dc;
      box-shadow: 0 0 10px 2px gold;
      transform: scale(1.01);
    }

    .message-box strong {
      color: #6d3c8f;
    }

    .back-button {
      display: block;
      width: fit-content;
      margin: 40px auto 0;
      padding: 12px 24px;
      font-size: 16px;
      background-color: #6d3c8f;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .back-button:hover {
      background-color: #8548aa;
    }

    .timestamp {
  text-align: right;
  font-size: 14px;
  color: #555;
  margin-top: 10px;
  font-style: italic;
}

  </style>
</head>
<body>
  <h2 class="page-heading">🔮 Messages from Astrologer 🔮</h2>

  <?php if (!empty($messages)): ?>
    <?php foreach ($messages as $msg): ?>
      <div class="message-box">
<p><strong>Message:</strong> <?= nl2br(htmlspecialchars($msg['astrologer_msg'])) ?></p>

<p class="timestamp">📅 Sent on <?= date("d M Y, h:i A", strtotime($msg['created_at'])) ?></p>

      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p style="text-align:center; font-size: 18px;">No messages from the astrologer at this time.</p>
  <?php endif; ?>

  <a class="back-button" href="appointment_form.php">← Back to Appointment Form</a>
</body>
</html>
