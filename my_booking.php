<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="my_booking.css?v=1"> 
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="booking_page.html">Home</a></li>
                <li><a href="#">My Bookings</a></li>
                <li><a href="cancel.html">Cancel My Ticket</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>My Bookings</h1>
        <div class="booking-table">
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

            $sql = "SELECT bookings.pnr, passengers.name, passengers.age, passengers.gender, bookings.source, bookings.destination, bookings.date, bookings.class, bookings.seat_number, bookings.train_number FROM bookings INNER JOIN passengers ON bookings.pnr = passengers.booking_pnr WHERE bookings.user_id = " . $_SESSION['user_id'];
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>PNR</th><th>Name</th><th>Age</th><th>Gender</th><th>Source</th><th>Destination</th><th>Date</th><th>Class</th><th>Seat Number</th><th>Train Number</th></tr>";

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
            } else {
                echo "<p>No bookings found.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
