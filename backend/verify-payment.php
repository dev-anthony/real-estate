<?php
include '../Config/db.php';
session_start();

// Validate required parameters
if (!isset($_GET['reference']) || !isset($_GET['house_id'])) {
    die('Invalid request');
}

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_email'])) {
    die('User not logged in.');
}

// Sanitize variables
$reference = mysqli_real_escape_string($conn, $_GET['reference']);
$house_id = (int) $_GET['house_id'];
$user_id = (int) $_SESSION['user_id'];
$email = mysqli_real_escape_string($conn, $_SESSION['user_email']);

// Paystack secret key
$secret_key = 'sk_test_121ead708a856b3435c0c14108c6f4bd4eda8c84';

// Verify payment via Paystack API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . rawurlencode($reference));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer $secret_key"]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if ($result['status'] && $result['data']['status'] === 'success') {
    $amount_paid = $result['data']['amount'] / 100; // Convert from Kobo to Naira

    // Insert payment record
    $insert_query = "
        INSERT INTO payments (property_id, user_id, email, transaction_ref, amount, status) 
        VALUES ($house_id, $user_id, '$email', '$reference', $amount_paid, 'success')
    ";
    mysqli_query($conn, $insert_query) or die("DB Error: " . mysqli_error($conn));

    // Update house status
    $update_query = "UPDATE houses SET status='Booked' WHERE id=$house_id";
    mysqli_query($conn, $update_query) or die("DB Error: " . mysqli_error($conn));

    echo "✅ Payment successful! House booked.";
} else {
    echo "❌ Payment failed or not verified.";
}
?>
