<?php
$conn = new mysqli("localhost", "root", "", "vastu_users");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("No appointment ID provided.");
}

$id = (int)$_GET['id'];

// Update message and products if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $conn->real_escape_string($_POST['message']);
    $products = $_POST['products'] ?? '';
    $stmt = $conn->prepare("UPDATE appointments SET astrologer_msg = ?, products = ? WHERE id = ?");
    $stmt->bind_param("ssi", $message, $products, $id);
    $stmt->execute();
}// Handle Mark as Solved button
if (isset($_POST['mark_solved'])) {
    $stmt = $conn->prepare("UPDATE appointments SET status = 'solved' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    // Refresh the page to reflect updated status
    header("Location: ".$_SERVER['REQUEST_URI']);
    exit();
}


$result = $conn->query("SELECT * FROM appointments WHERE id = $id");
if (!$result || $result->num_rows === 0) {
    die("Appointment not found.");
}

$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Appointment Details</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 20px;
    }
    .container {
      background: #fff;
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
      color: #6a1b9a;
      margin-bottom: 20px;
    }
    p, label {
      font-size: 16px;
    }
    textarea {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      resize: vertical;
      margin-bottom: 15px;
    }
    button {
      background-color: #6a1b9a;
      color: white;
      font-weight: bold;
      cursor: pointer;
      padding: 8px 14px;
      border: none;
      border-radius: 6px;
      margin: 5px 0;
    }
    button:hover {
      background-color: #5e1787;
    }
    .product-gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
      gap: 15px;
      margin: 20px 0;
    }
    .product-card {
      background: #fafafa;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 15px;
      text-align: center;
      box-shadow: 0 0 5px rgba(0,0,0,0.05);
      font-size: 18px;
    }
    #cart-items {
      list-style: none;
      padding-left: 20px;
      color: #6a1b9a;
      margin-bottom: 15px;
    }
    #cart-items li {
      margin-bottom: 5px;
    }
    .remove-btn {
      background-color: #e53935;
      font-size: 12px;
      padding: 4px 8px;
      margin-left: 10px;
    }
    .remove-btn:hover {
      background-color: #c62828;
    }
  </style>
</head>
<body>
<div class="container">
  <?php if ($row['status'] !== 'solved'): ?>
  <form method="POST" style="text-align: center; margin-top: 20px;">
    <input type="hidden" name="mark_solved" value="1">
    <button type="submit" style="background-color: #2e7d32;">✅ Mark as Solved</button>
  </form>
<?php else: ?>
  <div style="text-align:center; font-size: 18px; color: green; margin-top: 20px;">
    ✅ This case is <strong>solved</strong>.
  </div>
<?php endif; ?>

  <h2>Appointment Details for <?= htmlspecialchars($row['name']) ?></h2>

  <p><strong>DOB:</strong> <?= htmlspecialchars($row['dob']) ?></p>
  <p><strong>Birthplace:</strong> <?= htmlspecialchars($row['birthplace']) ?></p>
  <p><strong>Profession:</strong> <?= htmlspecialchars($row['profession']) ?></p>
  <p><strong>Location:</strong> <?= htmlspecialchars($row['location']) ?></p>
  <p><strong>Phone:</strong> <?= htmlspecialchars($row['phone']) ?></p>
  <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($row['status'])) ?></p>
  <p><strong>User Problem:</strong> <?= nl2br(htmlspecialchars($row['user_problem'])) ?></p>

  <form method="POST" onsubmit="return submitCart()">
    <label for="message">Send Message</label>
    <textarea name="message" id="message" rows="4" required><?= htmlspecialchars($row['astrologer_msg']) ?></textarea>

    <label>Select Products</label>
    <div class="product-gallery" id="product-list">
      <?php
        $products = [
          "Ketukata" => "🪬",
          "Budhkata" => "🧠",
          "Shukra kata" => "💎",
          "Surya kata" => "☀️",
          "Guru kata" => "📿",
          "Rahu kata" => "🌑",
          "Mangal katta" => "🔥"
        ];
        foreach ($products as $prod => $icon) {
          echo "
          <div class='product-card'>
            <div style='font-size: 30px;'>$icon</div>
            <p>$prod</p>
            <button type='button' onclick='addToCart(\"$prod\")'>Add to Cart</button>
          </div>";
        }
      ?>
    </div>

    <strong>🛒 Selected Products:</strong>
    <ul id="cart-items"></ul>

    <input type="hidden" name="products" id="cart-products" value="<?= htmlspecialchars($row['products']) ?>">
    <button type="submit">💌 Send Message & Products</button>
  </form>
<div style="text-align: center; margin-top: 30px;">
  <a href="appointments.php" style="text-decoration: none;">
    <button style="background-color: #4B2E83; padding: 10px 20px; border: none; border-radius: 6px; color: white; font-size: 16px; cursor: pointer;">
      ← Back to Dashboard
    </button>
  </a>
</div>

  
</div>

<script>
  const cart = new Set();
  const cartList = document.getElementById("cart-items");
  const cartInput = document.getElementById("cart-products");

  function addToCart(product) {
    if (!cart.has(product)) {
      cart.add(product);
      const li = document.createElement("li");
      li.textContent = product;

      const removeBtn = document.createElement("button");
      removeBtn.className = "remove-btn";
      removeBtn.textContent = "Remove";
      removeBtn.onclick = function() {
        cart.delete(product);
        cartList.removeChild(li);
        updateHiddenInput();
      };

      li.appendChild(removeBtn);
      cartList.appendChild(li);
      updateHiddenInput();
    }
  }

  function updateHiddenInput() {
    cartInput.value = Array.from(cart).join(", ");
  }

  function submitCart() {
    updateHiddenInput();
    return true;
  }

  // preload saved products
  window.onload = function () {
    const existing = cartInput.value.split(",").map(p => p.trim()).filter(p => p);
    existing.forEach(item => addToCart(item));
  };
</script>
</body>
</html>
