<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $dbname = "railwayssss";

    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $pnr = $_POST['pnr'];

    $deletePassengersStmt = $conn->prepare("DELETE FROM passengers WHERE booking_pnr = ?");
    $deletePassengersStmt->bind_param('s', $pnr);
    $deletePassengersStmt->execute();
    $deletePassengersStmt->close();

    $deleteBookingStmt = $conn->prepare("DELETE FROM bookings WHERE pnr = ? AND user_id = ?");
    $deleteBookingStmt->bind_param('si', $pnr, $_SESSION['user_id']);

    if ($deleteBookingStmt->execute()) {
        header("Location: my_booking.php");
        exit();
    } else {
        echo "Error cancelling ticket: " . $deleteBookingStmt->error;
    }

    $deleteBookingStmt->close();
    $conn->close();
}
?>
