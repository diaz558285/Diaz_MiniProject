<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['delete_id'])) {
    $id = (int) $_POST['delete_id'];
    $conn->query("DELETE FROM Contacts_Tbl WHERE id=$id");
}

$result = $conn->query("SELECT * FROM Contacts_Tbl ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Messages page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
    
    <a href="dashboard.php"><---- Back to Dashboard</a>

<h2>Messages from Visitors</h2>
<hr>

<table border="4" cellpadding="15">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Message</th>
    <th>Action</th>
</tr>

<?php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".htmlspecialchars($row['name'])."</td>";
    echo "<td>".htmlspecialchars($row['email'])."</td>";
    echo "<td>".nl2br(htmlspecialchars($row['message']))."</td>";
    echo "<td>
            <form method='POST' onsubmit='return confirm(\"Delete this message?\");'>
                <input type='hidden' name='delete_id' value='".$row['id']."'>
                <button type='submit'>Delete</button>
            </form>
          </td>";
    echo "</tr>";
}
?>

</table>
        </div>
    </div>

</body>
</html>

<?php $conn->close(); ?>