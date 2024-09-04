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

    // Retrieve form data
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $class = $_POST['class'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    
    $pnr = isset($_POST['pnr']) ? $_POST['pnr'] : mt_rand(100000000, 999999999);
    $seatNumber = mt_rand(1, 100);
    $trainNumber = mt_rand(10000, 99999);

    $bookingStmt = $conn->prepare("INSERT INTO bookings (user_id, source, destination, date, pnr, seat_number, class, train_number) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $bookingStmt->bind_param('isssissi', $_SESSION['user_id'], $source, $destination, $date, $pnr, $seatNumber, $class, $trainNumber);

    if ($bookingStmt->execute()) {
        $passengerStmt = $conn->prepare("INSERT INTO passengers (booking_pnr, name, age, gender) VALUES (?, ?, ?, ?)");
        $passengerStmt->bind_param('isss', $pnr, $name, $age, $gender);

        if ($passengerStmt->execute()) {
            header("Location: my_booking.php");
            exit();
        } else {
            echo "Error inserting passenger details: " . $passengerStmt->error;
        }
    } else {
        echo "Error inserting booking details: " . $bookingStmt->error;
    }

    $bookingStmt->close();
    $passengerStmt->close();
    $conn->close();
}
?>
