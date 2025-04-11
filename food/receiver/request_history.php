<?php
// request_history.php - Fetch donation history for the receiver
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'receiver') {
    header("Location: ../auth/login.php");
    exit();
}

include '../database/db_connect.php';

$user_id = $_SESSION['user_id'];

// Query to get the donations for the receiver (using the requests table to link donations to receiver)
$sql = "SELECT donations.id, donations.food_item, donations.quantity, donations.pickup_location, donations.expiry_date,  requests.request_status AS request_status, requests.created_at 
        FROM donations
        JOIN requests ON donations.id = requests.donation_id
        WHERE requests.receiver_id = ?";

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
    <title>Request History</title>
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
                    <h1 class="mt-4">Request History</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="view_donations.php">Back to Donations</a></li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Food Item</th>
                                        <th>Quantity</th>
                                        <th>Pickup Location</th>
                                        <th>Expiry Date</th>
                                        <th>Request Status</th>
                                        <th>Request Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['food_item']); ?></td>
                                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                            <td>
                                            <a href="#" onclick="showMap('<?= addslashes($row['pickup_location']) ?>'); return false;">
                                             <?= htmlspecialchars($row['pickup_location']) ?>
                                            </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
                                            <td><?php echo ucfirst($row['request_status']); ?></td>
                                            <td><?php echo $row['created_at']; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="../assets/js/datatables-simple-demo.js"></script>



<!-- Modal for Map -->
<div id="mapModal" style="display:none; position:fixed; top:10%; left:10%; width:80%; height:80%; background:#fff; border:1px solid #ccc; z-index:1000;">
    <div style="text-align:right; padding:5px;">
        <button onclick="document.getElementById('mapModal').style.display='none';">Close</button>
    </div>
    <div id="map" style="width:100%; height:90%;"></div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVq5rKWi3H0MiaVt_Wg7DujozaDH87Ly8"></script>
<script>
function showMap(location) {
    const geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': location }, function(results, status) {
        if (status === 'OK') {
            const mapModal = document.getElementById('mapModal');
            mapModal.style.display = 'block';
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: results[0].geometry.location
            });
            new google.maps.Marker({
                map: map,
                position: results[0].geometry.location
            });
        } else {
            alert('Could not find location: ' + status);
        }
    });
}
</script>


</body>
</html>
