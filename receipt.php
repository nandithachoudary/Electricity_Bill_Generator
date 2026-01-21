<?php
session_start();
$conn = new mysqli("localhost", "root", "", "electricity_bill_system");

$bill_id = $_GET['id'];
$bill = $conn->query("SELECT * FROM bills WHERE id='$bill_id'")->fetch_assoc();
$sc = $bill['sc_no'];
$user = $conn->query("SELECT * FROM users WHERE sc_no='$sc'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Receipt View</title>
</head>
<body style="background: #fff;"> <?php if($bill): ?>
<div class="receipt">
    <div class="center">
        <h3>T S S P D C L</h3>
        <p>ELECTRICITY BILL-CUM NOTICE</p>
    </div>
    <div class="dashed"></div>
    <div class="row"><span>MONTH: <?php echo $bill['month_year']; ?></span> <span>DT: <?php echo $bill['reading_date']; ?></span></div>
    
    <div class="dashed"></div>
    <div class="bold">SC.NO: <?php echo $user['sc_no']; ?></div>
    <div>NAME: <?php echo $user['full_name']; ?></div>
    <div>ADDR: <?php echo $user['address']; ?></div>
    
    <div class="dashed"></div>
    <div class="row"><span>Prev Reading:</span> <span><?php echo $bill['prev_reading']; ?></span></div>
    <div class="row"><span>Curr Reading:</span> <span><?php echo $bill['curr_reading']; ?></span></div>
    <div class="row"><span>Units:</span> <span><?php echo $bill['units_consumed']; ?></span></div>
    
    <div class="dashed"></div>
    <div class="row"><span>Charges:</span> <span><?php echo $bill['energy_charges'] + $bill['cust_charges'] + $bill['elec_duty']; ?></span></div>
    <div class="row"><span>Arrears:</span> <span><?php echo $bill['arrears']; ?></span></div>
    
    <div class="dashed"></div>
    <div class="row bold">
        <span>TOTAL DUE:</span> 
        <span><?php echo $bill['total_amount']; ?></span>
    </div>
    
    <div class="center" style="margin-top:15px;">
        STATUS: <?php echo $bill['status']; ?>
    </div>
</div>
<?php endif; ?>

</body>
</html>