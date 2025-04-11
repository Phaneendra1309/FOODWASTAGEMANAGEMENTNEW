<?php
// donor/view_requests.php - View Food Requests
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: ../auth/login.php");
    exit();
}
include '../database/db_connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT donations.id, donations.food_item, donations.quantity, donations.pickup_location, donations.expiry_date, requests.request_status AS request_status, requests.created_at, users.username AS receiver_name 
        FROM donations
        JOIN requests ON donations.id = requests.donation_id
        JOIN users ON requests.receiver_id = users.id
        WHERE donations.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>View Requests</title>
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
                    <h1 class="mt-4">View Food Requests</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Requests Pending Approval</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Receiver</th>
                                        <th>Food Item</th>
                                        <th>Quantity</th>
                                        <th>Pickup Location</th>
                                        <th>Expiry Date</th>
                                        <th>Request Status</th>
                                        <th>Request Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['receiver_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['food_item']); ?></td>
                                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                            <td><?php echo htmlspecialchars($row['pickup_location']); ?></td>
                                            <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                                            <td><?php echo ucfirst($row['request_status']); ?></td>
                                            <td><?php echo $row['created_at']; ?></td>
                                            <td>
                                                <!-- Disable buttons if request status is 'approved' or 'rejected' -->
                                                <?php if ($row['request_status'] !== 'approved' && $row['request_status'] !== 'rejected') { ?>
                                                    <a href="approve_request.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                                    <a href="reject_request.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                                <?php } else { ?>
                                                    <button class="btn btn-success btn-sm" disabled>Approved</button>
                                                    <button class="btn btn-danger btn-sm" disabled>Rejected</button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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

