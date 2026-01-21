<?php
session_start();
$conn = new mysqli("localhost", "root", "", "electricity_bill_system");

if (isset($_POST['login'])) {
    $role = $_POST['role'];
    $sc = $_POST['sc_no'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE sc_no='$sc' AND role='$role'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($pass == $row['password']) {
            $_SESSION['user'] = $sc;
            $_SESSION['role'] = $role;
            if ($role == 'admin') header("Location: admin.php");
            elseif ($role == 'supervisor') header("Location: supervisor.php");
            else header("Location: user_dashboard.php");
        } else echo "<script>alert('Wrong Password');</script>";
    } else echo "<script>alert('User not found!');</script>";
}
?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
    <div class="dashboard-card">
        <h2>⚡ TSSPDCL Portal</h2>
        <form method="POST">
            <label>Login As:</label>
            <select name="role">
                <option value="admin">Admin</option>
                <option value="supervisor">Supervisor</option>
                <option value="customer">Customer</option>
            </select>
            <input type="text" name="sc_no" placeholder="User ID / SC No" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>