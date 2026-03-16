<?php
session_start();

$error = "";

$admin_username = "diaz";
$admin_password = "diaz21";

if(isset($_POST['login'])) {

    if($_POST['username'] == $admin_username &&
       $_POST['password'] == $admin_password) {

        $_SESSION['loggedin'] = true;
        $_SESSION['admin_username'] = $admin_username;
        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <h2>Admin Login</h2>

            <?php if($error != "") echo "<p class='error' style='color: red; text-align: center; font-style: italic;'>$error</p>"; ?>

            <form method="POST">
                <label>Username:</label><br>
                <input type="text" name="username" required><br><br>

                <label>Password:</label><br>
                <input type="password" name="password" required><br><br>

                <button type="submit" name="login">Login</button>
            </form>

        </div>
    </div>
    


</body>
</html>