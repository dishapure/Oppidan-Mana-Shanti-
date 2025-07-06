<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>All Appointments</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      background: #f4f4f9;
      min-height: 100vh;
    }

    /* Sidebar */
    .sidebar {
      width: 260px;
      background-color: #4B2E83;
      color: white;
      padding: 30px 20px;
      display: flex;
      flex-direction: column;
      align-items: center;
      position: fixed;
      top: 70px;
      bottom: 0;
      left: 0;
    }

    .sidebar img {
      width: 90px;
      height: 90px;
      border-radius: 50%;
      margin-bottom: 15px;
      border: 3px solid white;
    }

    .sidebar h3 {
      margin-bottom: 25px;
      text-align: center;
    }

    .sidebar a {
      text-decoration: none;
      color: white;
      background-color: #6a1b9a;
      padding: 10px 15px;
      margin: 8px 0;
      border-radius: 8px;
      width: 100%;
      text-align: center;
      transition: background 0.3s;
    }

    .sidebar a:hover {
      background-color: #5e1787;
    }

    /* Top Navbar */
    .topbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 70px;
      background-color: #4B2E83;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 30px;
      z-index: 1000;
    }

    .topbar .brand {
      font-size: 24px;
      font-weight: bold;
      color:rgb(255, 255, 255);
    }

    .topbar nav {
      display: flex;
      align-items: center;
      gap: 25px;
    }

    .topbar nav a {
      color: white;
      text-decoration: none;
      font-size: 16px;
    }

    .topbar nav a:hover {
      text-decoration: underline;
    }

    /* Main content */
    .main {
      margin-left: 260px;
      margin-top: 70px;
      padding: 30px 40px;
      flex: 1;
      width: calc(100% - 260px);
    }

    /* Table Styling */
    table {
      border-collapse: collapse;
      width: 100%;
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    th, td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #6a1b9a;
      color: white;
    }

    h1 {
      color: #4a148c;
      margin-bottom: 20px;
    }

    .btn {
      padding: 6px 14px;
      border: none;
      border-radius: 4px;
      color: #fff;
      font-weight: bold;
      cursor: pointer;
    }

    .accept { background-color: #43a047; }
    .accept:hover { background-color: #388e3c; }
    .reject { background-color: #e53935; }
    .reject:hover { background-color: #c62828; }

    textarea {
      width: 100%;
      height: 60px;
      resize: vertical;
    }

    select {
      width: 100%;
      margin-top: 8px;
    }

    button[type="submit"] {
      margin-top: 8px;
      background: #6a1b9a;
      color: white;
      padding: 6px 14px;
      border: none;
      border-radius: 5px;
    }
  </style>
</head>

<body>

<!-- Top Navbar -->
<div class="topbar">
  <div class="brand">Vastu Consultancies</div>
  <nav>
    <a href="#">Home</a>
    <a href="#">About</a>
    <a href="#">Services</a>
    <a href="#">Reviews</a>
    <a href="logout.php" style="background:#6a1b9a;padding:6px 14px;border-radius:6px;">Logout</a>
  </nav>
</div>

<!-- Sidebar -->
<div class="sidebar">
  <img src="avatar.jpg" alt="User Avatar">
  <h3>Welcome, Admin</h3>
  <a href="show_appointments.php">All Appointments</a>
  <a href="graphs.php">Graphs</a>
</div>

<!-- Main Content -->
<div class="main">
  <h1>Dashboard Content</h1>
  <p>Here is where your dynamic PHP or graphs/appointments content goes.</p>
</div>

</body>
</html>
