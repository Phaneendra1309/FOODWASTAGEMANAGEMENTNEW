<?php
// receiver/request_food.php - Request Food Page
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'receiver') {
    header("Location: ../auth/login.php");
    exit();
}
include '../database/db_connect.php';

// Handle food request form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_item = $_POST['food_item'];
    $quantity = $_POST['quantity'];
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("INSERT INTO requests (user_id, food_item, quantity, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iss", $user_id, $food_item, $quantity);
    $stmt->execute();
    $stmt->close();
    
    $success = "Food request successfully submitted!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Request Food</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include '../includes/topbar.php'; ?>
    <div id="layoutSidenav">
        <?php include '../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Reduce Food Waste: Awareness Tip</h5>
                <p class="card-text">
                    Reducing food waste helps the environment and saves resources. Here are some tips:
                </p>
                <ul>
                    <li><strong>Plan your meals:</strong> Buy only what you need.</li>
                    <li><strong>Store food properly:</strong> Keep food fresh longer with correct storage.</li>
                    <li><strong>Check expiry labels:</strong> "Best Before" dates are about quality, not safety.</li>
                    <li><strong>Use leftovers creatively:</strong> Turn leftovers into new meals.</li>
                </ul>
            </div>
        </div>
                </div>
            </main>
            <?php include '../includes/footer.php'; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="../assets/js/datatables-simple-demo.js"></script>
</body>
</html>