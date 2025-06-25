<?php
$conn = new mysqli("localhost", "root", "", "vastu_users");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT id, name, created_at FROM appointments ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Appointments</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f3f3f8;
      padding: 20px;
    }

    h2 {
      text-align: center;
      color: #4a148c;
    }

    .list {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
      margin-top: 30px;
    }

    .card {
      width: 90%;
      max-width: 600px;
      background: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-decoration: none;
      color: #333;
      transition: 0.3s ease;
    }

    .card:hover {
      background-color: #e8f0fe;
      transform: scale(1.02);
    }

    .card h3 {
      margin: 0;
      font-size: 22px;
      color: #6a1b9a;
    }

    .card p {
      margin: 5px 0 0;
      font-size: 14px;
      color: #666;
    }
    .card {
  display: flex;
  align-items: center;
  gap: 20px;
  ...
}

.card img.avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  border: 2px solid #6a1b9a;
}
.back-btn-wrapper {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 30px 0;
}

.back-btn {
  padding: 12px 30px;
  background-color: #6a1b9a;
  color: white;
  text-decoration: none;
  font-size: 16px;
  font-weight: bold;
  border-radius: 8px;
  transition: background-color 0.3s ease;
  text-align: center;
}

.back-btn:hover {
  background-color: #5e1787;
}



  </style>
</head>
<body>

<h2>🔮 All Appointments</h2>
<a href="appointments.php" class="back-btn">← Back to Dashboard</a>


<div class="list">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
      <a class="card" href="appointment_details.php?id=<?= $row['id'] ?>">
        <img src="avatar2.png" alt="Avatar" class="avatar">

        <h3><?= htmlspecialchars($row['name']) ?></h3>
        <p>Created: <?= date("d M Y, h:i A", strtotime($row['created_at'])) ?></p>
      </a>
    <?php endwhile; ?>
  <?php else: ?>
    <p style="text-align:center; color: #888;">No appointments found.</p>
  <?php endif; ?>
</div>

</body>
</html>
