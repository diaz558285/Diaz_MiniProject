<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
        <h1>Welcome, <?php echo $_SESSION['admin_username']; ?>!</h1>
    
        <ul>
           <li><a href="projects.php">Manage Projects</a></li>
           <li><a href="skills.php">Manage Skills</a></li>
           <li><a href="experiences.php">Manage Experiences</a></li>
           <li><a href="messages.php">View Messages</a></li> 
           <li><a href="../logout.php">Logout</a></li>
        </ul>
        </div>
    </div>


</body>
</html>