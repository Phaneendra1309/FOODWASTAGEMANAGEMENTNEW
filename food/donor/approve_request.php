<?php
// approve_request.php - Mark a request as approved
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'donor') {
    header("Location: ../auth/login.php");
    exit();
}

include '../database/db_connect.php';

if (isset($_GET['id'])) {
    $donation_id = $_GET['id'];

    $sql = "UPDATE requests SET request_status = 'approved' WHERE donation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donation_id);

    if ($stmt->execute()) {
        // Also update the donation's request_status to 'approved'
        $updateDonation = $conn->prepare("UPDATE donations SET request_status = 'approved' WHERE id = ?");
        $updateDonation->bind_param("i", $donation_id);
        $updateDonation->execute();
    }

    $stmt->close();
    $conn->close();
}

header("Location: view_requests.php");
exit();
?>
