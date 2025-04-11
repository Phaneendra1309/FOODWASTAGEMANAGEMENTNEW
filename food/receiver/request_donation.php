<?php
// request_donation.php - Receiver Requests a Donation
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'receiver') {
    header("Location: ../auth/login.php");
    exit();
}

include '../database/db_connect.php';

$user_id = $_SESSION['user_id'];

// Check if the donation ID is passed and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $donation_id = $_GET['id'];

    // Step 1: Check if the donation is available and hasn't been claimed
    $sql = "SELECT * FROM donations WHERE id = ? AND request_status = 'available' AND receiver_id IS NULL";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $donation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Donation is available to be claimed

        // Step 2: Update the donations table with the receiver_id
        $sql = "UPDATE donations SET receiver_id = ?, request_status = 'requested' WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $user_id, $donation_id);
        if ($stmt->execute()) {
            // Step 3: Insert the request into the requests table
            $sql = "INSERT INTO requests (receiver_id, donation_id, request_status) VALUES (?, ?, 'requested')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $user_id, $donation_id);
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Donation claimed successfully!";
            } else {
                $_SESSION['error_message'] = "Error while inserting request into the database.";
            }
        } else {
            $_SESSION['error_message'] = "Error while updating donation status.";
        }
    } else {
        $_SESSION['error_message'] = "This donation is no longer available or has already been claimed.";
    }
} else {
    $_SESSION['error_message'] = "Invalid donation ID.";
}

header("Location: view_donations.php");
exit();
?>
