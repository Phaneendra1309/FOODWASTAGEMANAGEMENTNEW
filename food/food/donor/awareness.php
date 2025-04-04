<?php
// donor/donation_history.php - Donation History Page
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: ../auth/login.php");
    exit();
}
include '../database/db_connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT id, food_item, quantity, pickup_location, expiry_date, status FROM donations WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Donation History</title>
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
                <h5 class="card-title">Awareness Tip for Food Donors</h5>
                <p class="card-text">
                    Your donation can make a real difference! Here’s how you can donate food responsibly:
                </p>
                <ul>
                    <li><strong>Donate Fresh and Safe Food:</strong> Ensure donated food is not expired or spoiled.</li>
                    <li><strong>Follow Proper Packaging:</strong> Use clean, sealed containers to maintain hygiene.</li>
                    <li><strong>Consider Nutritional Value:</strong> Donate wholesome, nutritious food to support healthy eating.</li>
                    <li><strong>Check Local Guidelines:</strong> Follow food safety regulations and donation policies.</li>
                    <li><strong>Connect with Food Banks:</strong> Reach out to local shelters and food banks for organized distribution.</li>
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