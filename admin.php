<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') header("Location: index.php");
$conn = new mysqli("localhost", "root", "", "electricity_bill_system");

if (isset($_POST['register'])) {
    $sc = $_POST['sc_no'];
    $pass = $_POST['password'];
    $usc = $_POST['usc'];
    $name = $_POST['name'];
    $addr = $_POST['addr'];
    $cat = $_POST['cat'];
    $load = $_POST['load'];
    $meter = $_POST['meter'];
    $ero = $_POST['ero'];

    $sql = "INSERT INTO users (sc_no, password, role, usc_no, full_name, address, category, contracted_load, meter_no, ero_code) 
            VALUES ('$sc', '$pass', 'customer', '$usc', '$name', '$addr', '$cat', '$load', '$meter', '$ero')";
    
    if ($conn->query($sql)) echo "<script>alert('User Registered!');</script>";
    else echo "<script>alert('Error: SC No already exists');</script>";
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="dashboard-card" style="width: 400px;">
        <h3>Admin: Register User</h3>
        <form method="POST">
            <input type="text" name="sc_no" placeholder="SC No (Login ID)" required>
            <input type="text" name="password" placeholder="Set Password" required>
            <input type="text" name="usc" placeholder="USC Number" required>
            <input type="text" name="name" placeholder="Customer Name" required>
            <input type="text" name="addr" placeholder="Address (H No, Area)" required>
            <input type="text" name="cat" placeholder="Category (e.g. 1B(ii))" required>
            <input type="text" name="load" placeholder="Load (e.g. 1.00KW)" required>
            <input type="text" name="meter" placeholder="Meter No" required>
            <input type="text" name="ero" placeholder="ERO Code" required>
            <button type="submit" name="register">Register User</button>
        </form>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>