<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'supervisor') {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "electricity_bill_system");

if (isset($_POST['generate'])) {
    $sc = $_POST['sc_no'];
    $curr_reading = $_POST['curr_reading'];
    $bill_month = $_POST['bill_month']; 
    
    $check_sql = "SELECT * FROM bills WHERE sc_no='$sc' AND month_year='$bill_month'";
    $existing = $conn->query($check_sql)->fetch_assoc();

    $last_sql = "SELECT * FROM bills WHERE sc_no='$sc' AND month_year!='$bill_month' ORDER BY id DESC LIMIT 1";
    $last_bill = $conn->query($last_sql)->fetch_assoc();

    if ($existing) {
        $prev_reading = $existing['prev_reading']; 
    } else {
        $prev_reading = ($last_bill) ? $last_bill['curr_reading'] : 0;
    }

    $units = $curr_reading - $prev_reading;
    if ($units < 0) $units = 0;

    $energy_charge = $units * 3.00;
    $duty = $units * 0.05;
    $cust_charge = 60.00;

    $arrears = 0;
    if ($last_bill && $last_bill['status'] == 'Unpaid') {
        $arrears = $last_bill['total_amount'];
    }

    $total = $energy_charge + $cust_charge + $duty + $arrears;
    $date = date('Y-m-d');

    if ($existing) {
        $id = $existing['id'];
        $sql = "UPDATE bills SET curr_reading='$curr_reading', units_consumed='$units', 
                energy_charges='$energy_charge', elec_duty='$duty', arrears='$arrears', total_amount='$total' 
                WHERE id='$id'";
        $msg = "Updated bill for $bill_month";
    } else {
        $sql = "INSERT INTO bills (sc_no, month_year, reading_date, prev_reading, curr_reading, units_consumed, energy_charges, cust_charges, elec_duty, arrears, total_amount, status) 
                VALUES ('$sc', '$bill_month', '$date', '$prev_reading', '$curr_reading', '$units', '$energy_charge', '$cust_charge', '$duty', '$arrears', '$total', 'Unpaid')";
        $msg = "Generated new bill for $bill_month";
    }

    if ($conn->query($sql)) echo "<script>alert('✅ $msg');</script>";
    else echo "<script>alert('Error');</script>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Supervisor</title><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="dashboard-card">
        <h3>Supervisor Entry</h3>
        <form method="POST">
            <input type="text" name="sc_no" placeholder="Customer SC No" required>
            <label style="display:block; text-align:left;">For Month:</label>
            <input type="month" name="bill_month" required>
            <input type="number" name="curr_reading" placeholder="Current Reading" required>
            <button type="submit" name="generate">Submit</button>
        </form>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>