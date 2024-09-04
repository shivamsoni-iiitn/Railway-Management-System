<?php
$host = 'localhost';
$dbname = 'railwayssss'; 
$username = 'root'; 
$password = ''; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 
    $phonenumber = $_POST['phonenumber'];
    $gender = $_POST['gender'];
    $maritalStatus = $_POST['maritalStatus'];
    $dob = $_POST['dob'];
    $pincode = $_POST['pincode'];
    $irctcUsername = $_POST['irctcUsername'];
    $securityQues = $_POST['securityQues'];
    $securityAns = $_POST['securityAns'];

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, phonenumber, gender, maritalStatus, dob, pincode, irctcUsername, securityQues, securityAns) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$firstname, $lastname, $email, $password, $phonenumber, $gender, $maritalStatus, $dob, $pincode, $irctcUsername, $securityQues, $securityAns]);

    header("Location: login.html");
    exit();
}
?>
