<?php
$conn = new mysqli("localhost", "root", "", "electricity_bill_system");
$sc_no = $_GET['sc_no'];

if(isset($_POST['set_pass'])) {
    $p = $_POST['new_pass'];
    $conn->query("UPDATE users SET password='$p' WHERE sc_no='$sc_no'");
    header("Location: index.php");
}
?>
<h3>Set Your Password</h3>
<form method="POST">
    <input type="password" name="new_pass" placeholder="New Password" required>
    <button type="submit" name="set_pass">Set Password</button>
</form>