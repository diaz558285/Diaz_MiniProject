<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE TABLE IF NOT EXISTS Experiences_Tbl (
    Experience_ID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(100) NOT NULL,
    Company VARCHAR(100) NOT NULL,
    Start_Date DATE NOT NULL,
    End_Date DATE,
    Description TEXT
)");

if (isset($_POST['submit'])) {
    $exp_id = $_POST['Experience_ID'] ?? '';
    $title = $_POST['Title'];
    $company = $_POST['Company'];
    $start = $_POST['Start_Date'];
    $end = $_POST['End_Date'];
    $desc = $_POST['Description'];

    if ($exp_id == "") {
        $conn->query("INSERT INTO Experiences_Tbl (Title, Company, Start_Date, End_Date, Description)
                      VALUES ('$title', '$company', '$start', '$end', '$desc')");
        echo "<p>Experience added successfully!</p>";
    } else {
        $conn->query("UPDATE Experiences_Tbl
                      SET Title='$title', Company='$company', Start_Date='$start', End_Date='$end', Description='$desc'
                      WHERE Experience_ID=$exp_id");
        echo "<p>Experience updated successfully!</p>";
    }
}

if (isset($_POST['delete_id'])) {
    $exp_id = (int) $_POST['delete_id'];
    $conn->query("DELETE FROM Experiences_Tbl WHERE Experience_ID=$exp_id");
    echo "<p>Experience deleted successfully!</p>";
}

$edit_id = "";
$edit_title = "";
$edit_company = "";
$edit_start = "";
$edit_end = "";
$edit_desc = "";

if (isset($_POST['edit_id'])) {
    $edit_id = (int) $_POST['edit_id'];
    $result = $conn->query("SELECT * FROM Experiences_Tbl WHERE Experience_ID=$edit_id");
    $row = $result->fetch_assoc();
    $edit_title = $row['Title'];
    $edit_company = $row['Company'];
    $edit_start = $row['Start_Date'];
    $edit_end = $row['End_Date'];
    $edit_desc = $row['Description'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Experiences Page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <div class="card">

<h2><?php echo $edit_id ? "Edit Experience" : "Add Experience"; ?></h2>

<form method="POST">
    <input type="hidden" name="Experience_ID" value="<?php echo $edit_id; ?>">

    <label>Title:</label><br>
    <input type="text" name="Title" value="<?php echo $edit_title; ?>" required><br><br>

    <label>Company:</label><br>
    <input type="text" name="Company" value="<?php echo $edit_company; ?>" required><br><br>

    <label>Start Date:</label><br>
    <input type="date" name="Start_Date" value="<?php echo $edit_start; ?>" required><br><br>

    <label>End Date:</label><br>
    <input type="date" name="End_Date" value="<?php echo $edit_end; ?>"><br><br>

    <label>Description:</label><br>
    <textarea name="Description"><?php echo $edit_desc; ?></textarea><br><br>

    <button type="submit" name="submit"><?php echo $edit_id ? "Update" : "Save"; ?></button>
</form>
<a href="dashboard.php"><--- Back to Dashboard</a>


<hr>

<h2>List of Experiences</h2>
<table border="5" cellpadding="8">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Company</th>
    <th>Start</th>
    <th>End</th>
    <th>Description</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM Experiences_Tbl");
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['Experience_ID']."</td>";
    echo "<td>".$row['Title']."</td>";
    echo "<td>".$row['Company']."</td>";
    echo "<td>".$row['Start_Date']."</td>";
    echo "<td>".$row['End_Date']."</td>";
    echo "<td>".$row['Description']."</td>";
    echo "<td>
            <form method='POST' style='display:inline'>
                <input type='hidden' name='edit_id' value='".$row['Experience_ID']."'>
                <button type='submit'>Edit</button>
            </form>
            <form method='POST' style='display:inline'>
                <input type='hidden' name='delete_id' value='".$row['Experience_ID']."'>
                <button type='submit' onclick=\"return confirm('Delete this Experience?')\">Delete</button>
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