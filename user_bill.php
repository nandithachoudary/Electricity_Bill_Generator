<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "electricity_bill_system");
$sc = $_SESSION['user'];

// 1. Payment logic
if (isset($_POST['pay_bill'])) {
    $id_to_pay = $_POST['bill_id'];
    $conn->query("UPDATE bills SET status='Paid' WHERE id='$id_to_pay'");
    echo "<script>alert('Payment Successful!'); window.location.href='user_bill.php';</script>";
}

// 2. Fetch data
$user = $conn->query("SELECT * FROM users WHERE sc_no='$sc'")->fetch_assoc();
$bill = $conn->query("SELECT * FROM bills WHERE sc_no='$sc' ORDER BY id DESC LIMIT 1")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <style>
        .pay-btn { background-color: #28a745; color: white; padding: 10px; border: none; cursor: pointer; width: 100%; margin-top: 10px; font-weight: bold; }
        .pay-btn:hover { background-color: #218838; }
        .paid-stamp { border: 2px solid #28a745; color: #28a745; font-weight: bold; padding: 5px; transform: rotate(-10deg); display: inline-block; margin-top: 10px; }
        .unpaid-text { color: red; font-weight: bold; }
    </style>
</head>
<body>

<?php if($bill): ?>
<div class="receipt">
    <div class="center">
        <h3>T S S P D C L</h3>
        <p>ELECTRICITY BILL-CUM NOTICE</p>
    </div>
    
    <div class="dashed"></div>
    
    <div class="row"><span>DT:<?php echo $bill['reading_date']; ?></span> <span>TI:10:00</span></div>
    <div>ERO: <?php echo $user['ero_code']; ?></div>
    
    <div class="dashed"></div>
    
    <div class="bold" style="font-size: 14px;">SC.NO: <?php echo $user['sc_no']; ?></div>
    <div>USC : <?php echo $user['usc_no']; ?></div>
    <div>NAME: <?php echo $user['full_name']; ?></div>
    <div>ADDR: <?php echo $user['address']; ?></div>
    <div style="margin-top:5px;">CAT: <?php echo $user['category']; ?></div>
    <div>CONTRACTED LOAD: <?php echo $user['contracted_load']; ?></div>
    
    <div class="dashed"></div>
    
    <div class="row" style="text-decoration: underline;">
        <span>PREVIOUS</span> <span>PRESENT</span>
    </div>
    <div class="row">
        <span><?php echo $bill['prev_reading']; ?></span> 
        <span><?php echo $bill['curr_reading']; ?></span>
    </div>
    
    <div class="row" style="margin-top:5px;">
        <span>UNITS: <?php echo $bill['units_consumed']; ?></span>
        
        <span>STATUS: 
            <?php if($bill['status'] == 'Paid'): ?>
                <span style="color:green; font-weight:bold;">PAID</span>
            <?php else: ?>
                <span class="unpaid-text">UNPAID</span>
            <?php endif; ?>
        </span>
    </div>
    
    <div class="dashed"></div>
    
    <div class="row"><span>ENERGY CHARGES:</span> <span><?php echo $bill['energy_charges']; ?></span></div>
    <div class="row"><span>CUST CHARGES :</span> <span><?php echo $bill['cust_charges']; ?></span></div>
    <div class="row"><span>ELECTRICI DUTY:</span> <span><?php echo $bill['elec_duty']; ?></span></div>
    <div class="row"><span>ARREARS :</span> <span><?php echo $bill['arrears']; ?></span></div>
    
    <div class="dashed"></div>
    
    <div class="row bold" style="font-size: 14px;">
        <span>NET AMOUNT :</span> 
        <span><?php echo $bill['total_amount']; ?></span>
    </div>

    <div class="center">
        <?php if($bill['status'] == 'Unpaid'): ?>
            <form method="POST">
                <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
                <button type="submit" name="pay_bill" class="pay-btn">PAY NOW</button>
            </form>
        <?php else: ?>
            <div class="paid-stamp">PAYMENT RECEIVED</div>
        <?php endif; ?>
    </div>
    
    <center><a href="logout.php" class="logout">Logout</a></center>
</div>
<?php else: ?>
    <div class="dashboard-card">
        <h3>No Bill Generated Yet</h3>
        <a href="logout.php" class="logout">Logout</a>
    </div>
<?php endif; ?>

</body>
</html>