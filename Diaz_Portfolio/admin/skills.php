<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "portfolio_db";

$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

$conn->query("CREATE TABLE IF NOT EXISTS Skills_Tbl (
    Skill_ID INT AUTO_INCREMENT PRIMARY KEY,
    Skill_Name VARCHAR(50) NOT NULL,
    Skill_Level VARCHAR(20) NOT NULL
)");

if (isset($_POST['submit'])) {
    
    $skill_id     = $_POST['Skill_ID'] ?? '';
    $skill_name   = $_POST['Skill_Name'];
    $skill_level = $_POST['Skill_Level'];

    if ($skill_id == "") {
        $conn->query("INSERT INTO Skills_Tbl (Skill_Name, Skill_Level)
                      VALUES ('$skill_name', '$skill_level')");
        echo "<p>Skill added successfully!</p>";
    } else {
        $conn->query("UPDATE Skills_Tbl
                      SET Skill_Name='$skill_name',
                          Skill_Level='$skill_level'
                      WHERE Skill_ID=$skill_id");
        echo "<p>Product updated successfully!</p>";
    }
}

if (isset($_POST['delete_id'])) {
    $skill_id = (int) $_POST['delete_id'];
    $conn->query("DELETE FROM Skills_Tbl WHERE Skill_ID=$skill_id");
    echo "<p>Skill deleted successfully!</p>";
}

$edit_sid = "";
$edit_sname = "";
$edit_slevel = "";

if (isset($_POST['edit_sid'])) {
    $edit_sid = (int) $_POST['edit_sid'];
    $result = $conn->query("SELECT * FROM Skills_Tbl WHERE Skill_ID=$edit_sid");
    $row = $result->fetch_assoc();
    $edit_sname = $row['Skill_Name'];
    $edit_slevel = $row['Skill_Level'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Skills Page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container">
        <div class="card">
 <a href="dashboard.php"><--- Back to Dashboard</a>

<h2><?php echo $edit_sid ? "Edit Skill" : "Add Skill"; ?></h2>

<form method="POST">

    <input type="hidden" name="Skill_ID" value="<?php echo $edit_sid; ?>">

    <label for="Skill_Name">Skill Name:</label>
    <input type="text" name="Skill_Name"
           value="<?php echo $edit_sname; ?>" required>

    <label for="Skill_Level">Skill Level:</label>       
    <select name="Skill_Level" required>
        <option value="Beginner" <?= $edit_slevel == 'Beginner' ? 'selected' : '' ?>>Beginner</option>
        <option value="Intermediate" <?= $edit_slevel == 'Intermediate' ? 'selected' : '' ?>>Intermediate</option>
        <option value="Advanced" <?= $edit_slevel == 'Advanced' ? 'selected' : '' ?>>Advanced</option>
        <option value="Expert" <?= $edit_slevel == 'Expert' ? 'selected' : '' ?>>Expert</option>
    </select>

    <button type="submit" name="submit">
        <?php echo $edit_sid ? "Update" : "Save"; ?>
    </button>

</form>

<hr>

<h2>List of Skills</h2>
<table border="5" cellpadding="20">
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Level</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM Skills_Tbl");

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['Skill_ID']."</td>";
    echo "<td>".$row['Skill_Name']."</td>";
    echo "<td>".$row['Skill_Level']."</td>";
    echo "<td>
            <form method='POST' style='display:inline'>
                <input type='hidden' name='edit_sid' value='".$row['Skill_ID']."'>
                <button type='submit'>Edit</button>
            </form>

            <form method='POST' style='display:inline'>
                <input type='hidden' name='delete_id' value='".$row['Skill_ID']."'>
                <button type='submit' onclick=\"return confirm('Delete this Skill?')\">
                    Delete
                </button>
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

<?php
$conn->close();
?>