<?php
// request_details.php - View Request Details
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../database/db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $request_id = $_GET['id'];

    // Get details of the request
    $sql = "SELECT requests.id, users.username, donations.food_item, donations.quantity, donations.pickup_location, donations.expiry_date, donations.description, requests.status, requests.created_at 
            FROM requests 
            JOIN users ON requests.user_id = users.id 
            JOIN donations ON requests.donation_id = donations.id 
            WHERE requests.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Request not found.";
        header("Location: view_requests.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request ID.";
    header("Location: view_requests.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Request Details</title>
    <link href="../assets/css/styles.css" rel="stylesheet" />
</head>
<body>
    <?php include '../includes/topbar.php'; ?>
    <div id="layoutSidenav">
        <?php include '../includes/sidebar.php'; ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Request Details</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="view_requests.php">Back to Requests</a></li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5><strong>Receiver: </strong><?php echo htmlspecialchars($row['username']); ?></h5>
                            <h5><strong>Food Item: </strong><?php echo htmlspecialchars($row['food_item']); ?></h5>
                            <h5><strong>Quantity: </strong><?php echo htmlspecialchars($row['quantity']); ?></h5>
                            <h5><strong>Pickup Location: </strong><?php echo htmlspecialchars($row['pickup_location']); ?></h5>
                            <h5><strong>Expiry Date: </strong><?php echo htmlspecialchars($row['expiry_date']); ?></h5>
                            <h5><strong>Description: </strong><?php echo htmlspecialchars($row['description']); ?></h5>
                            <h5><strong>Status: </strong><?php echo ucfirst($row['status']); ?></h5>
                            <h5><strong>Request Created At: </strong><?php echo $row['created_at']; ?></h5>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
