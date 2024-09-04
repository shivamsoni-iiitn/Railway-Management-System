<?php
session_start();

$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "railwayssss";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['pnr'])) {
    $pnr = $_GET['pnr'];

    $sql = "SELECT bookings.pnr, passengers.name, passengers.age, passengers.gender, bookings.source, bookings.destination, bookings.date, bookings.class, bookings.seat_number, bookings.train_number FROM bookings INNER JOIN passengers ON bookings.pnr = passengers.booking_pnr WHERE bookings.pnr = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $pnr);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<!DOCTYPE html>";
        echo "<html lang='en'>";
        echo "<head>";
        echo "<meta charset='UTF-8'>";
        echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
        echo "<title>Passenger Details</title>";
        // CSS styles
        echo "<style>";
        echo "table {";
        echo "    width: 100%;";
        echo "    border-collapse: collapse;";
        echo "}";
        echo "th, td {";
        echo "    border: 1px solid #ddd;";
        echo "    padding: 8px;";
        echo "    text-align: left;";
        echo "}";
        echo "th {";
        echo "    background-color: #f2f2f2;";
        echo "}";
        echo "</style>";
        echo "</head>";
        echo "<body>";
        echo "<h1>Passenger Booking Details</h1>";
        echo "<table>";
        echo "<tr>";
        echo "<th>PNR</th>";
        echo "<th>Name</th>";
        echo "<th>Age</th>";
        echo "<th>Gender</th>";
        echo "<th>Source</th>";
        echo "<th>Destination</th>";
        echo "<th>Date</th>";
        echo "<th>Class</th>";
        echo "<th>Seat Number</th>";
        echo "<th>Train Number</th>";
        echo "</tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['pnr'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['age'] . "</td>";
            echo "<td>" . $row['gender'] . "</td>";
            echo "<td>" . $row['source'] . "</td>";
            echo "<td>" . $row['destination'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['class'] . "</td>";
            echo "<td>" . $row['seat_number'] . "</td>";
            echo "<td>" . $row['train_number'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</body>";
        echo "</html>";
    } else {
        echo "No booking found with this PNR.";
    }

    $stmt->close();
} else {
    echo "PNR not provided.";
}

$conn->close();
?>
