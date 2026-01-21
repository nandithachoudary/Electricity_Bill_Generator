<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'customer') {
    header("Location: index.php");
    exit();
}
$conn = new mysqli("localhost", "root", "", "electricity_bill_system");
$sc = $_SESSION['user'];

if (isset($_POST['pay_latest'])) {
    // 1. Marking all bills for this user as Paid (Clearing the slate)
    $conn->query("UPDATE bills SET status='Paid' WHERE sc_no='$sc'");
    echo "<script>alert('Payment Successful! Account Cleared.'); window.location='user_dashboard.php';</script>";
}
//fetching all bills
$result = $conn->query("SELECT * FROM bills WHERE sc_no='$sc' ORDER BY month_year DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bills</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background-color: #007bff; color: white; }
        .btn-view { background: #17a2b8; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; }
        .btn-pay { background: #28a745; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="dashboard-card" style="width: 800px;">
        <h2>My Bill History</h2>
        
        <table>
            <tr>
                <th>Month</th>
                <th>Units</th>
                <th>Bill Amount</th>
                <th>Arrears Added</th>
                <th>Total Due</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            
            <?php 
            $is_latest = true; // to track the top row
            while($row = $result->fetch_assoc()): 
            ?>
            <tr>
                <td><?php echo $row['month_year']; ?></td>
                <td><?php echo $row['units_consumed']; ?></td>
                <td><?php echo $row['energy_charges'] + $row['cust_charges'] + $row['elec_duty']; ?></td>
                <td><?php echo $row['arrears']; ?></td>
                <td><strong><?php echo $row['total_amount']; ?></strong></td>
                
                <td>
                    <?php if($row['status']=='Paid'): ?>
                        <span style="color:green; font-weight:bold;">PAID</span>
                    <?php else: ?>
                        <span style="color:red; font-weight:bold;">UNPAID</span>
                    <?php endif; ?>
                </td>
                
                <td>
                    <a href="receipt.php?id=<?php echo $row['id']; ?>" class="btn-view" target="_blank">Receipt</a>
                    
                    <?php if($is_latest && $row['status'] == 'Unpaid'): ?>
                        <form method="POST" style="display:inline;">
                            <button type="submit" name="pay_latest" class="btn-pay">Pay Now</button>
                        </form>
                    <?php endif; ?>
                </td>
            </tr>
            <?php 
            $is_latest = false; 
            endwhile; 
            ?>
        </table>
        
        <br>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</body>
</html>