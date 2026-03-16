<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "portfolio_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("CREATE TABLE IF NOT EXISTS Projects_Tbl (
    Project_ID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(100) NOT NULL,
    Description TEXT NOT NULL,
    Link VARCHAR(255),
    Project_Image LONGBLOB
)");

$edit_id = $edit_title = $edit_desc = $edit_link = $edit_image = "";

// Handle Save (Add or Update)
if (isset($_POST['submit'])) {
    $proj_id = $_POST['Project_ID'] ?? '';
    $title   = $_POST['Title'];
    $desc    = $_POST['Description'];
    $link    = $_POST['Link'];

    // Handle image upload if a file is selected
    $image = null;
    if (!empty($_FILES['Project_Image']['tmp_name'])) {
        $image = addslashes(file_get_contents($_FILES['Project_Image']['tmp_name']));
    }

    if ($proj_id) {
        // Update existing project
        $sql = "UPDATE Projects_Tbl SET Title='$title', Description='$desc', Link='$link'";
        if ($image) {
            $sql .= ", Project_Image='$image'";
        }
        $sql .= " WHERE Project_ID=$proj_id";
        $conn->query($sql);
        echo "<p>Project updated successfully!</p>";
    } else {
        // Add new project
        $conn->query("INSERT INTO Projects_Tbl (Title, Description, Link, Project_Image)
                      VALUES ('$title', '$desc', '$link', '$image')");
        echo "<p>Project added successfully!</p>";
    }
}

// Handle Delete
if (isset($_POST['delete_id'])) {
    $proj_id = (int) $_POST['delete_id'];
    $conn->query("DELETE FROM Projects_Tbl WHERE Project_ID=$proj_id");
    echo "<p>Project deleted successfully!</p>";
}

// Handle Edit (load data into form)
if (isset($_POST['edit_id'])) {
    $edit_id = (int) $_POST['edit_id'];
    $row = $conn->query("SELECT * FROM Projects_Tbl WHERE Project_ID=$edit_id")->fetch_assoc();
    $edit_title = $row['Title'];
    $edit_desc  = $row['Description'];
    $edit_link  = $row['Link'];
    $edit_image = $row['Project_Image'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Projects Page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            
<h2><?php echo $edit_id ? "Edit Project" : "Add Project"; ?></h2>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="Project_ID" value="<?php echo $edit_id; ?>">

    <label>Title:</label><br>
    <input type="text" name="Title" value="<?php echo $edit_title; ?>" required><br><br>

    <label>Description:</label><br>
    <textarea name="Description" required><?php echo $edit_desc; ?></textarea><br><br>

    <label>Link (optional):</label><br>
    <input type="text" name="Link" value="<?php echo $edit_link; ?>"><br><br>

    <label>Image (optional):</label><br>
    <input type="file" name="Project_Image"><br>
    <?php if ($edit_image) : ?>
        <p>Current Image:</p>
        <img width="80" height="90" src="data:image/jpeg;base64,<?php echo base64_encode($edit_image); ?>">
    <?php endif; ?>
    <br><br>

    <button type="submit" name="submit"><?php echo $edit_id ? "Update" : "Save"; ?></button>
</form><br><br>
 <a href="dashboard.php"><--- Back to Dashboard</a>
        </div>


<hr>


<h2>List of Projects</h2>
<table border="5" cellpadding="40" style='background-color:white;'>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Description</th>
    <th>Link</th>
    <th>Image</th>
    <th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM Projects_Tbl");
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['Project_ID']."</td>";
    echo "<td>".$row['Title']."</td>";
    echo "<td>".$row['Description']."</td>";
    echo "<td>".$row['Link']."</td>";
    echo "<td>";
    if ($row['Project_Image']) {
        echo "<img width='80' height='90' src='data:image/jpeg;base64,".base64_encode($row['Project_Image'])."'>";
    }
    echo "</td>";
    echo "<td>
            <form method='POST' style='display:inline'>
                <input type='hidden' name='edit_id' value='".$row['Project_ID']."'>
                <button type='submit'>Edit</button>
            </form>
            <form method='POST' style='display:inline'>
                <input type='hidden' name='delete_id' value='".$row['Project_ID']."'>
                <button type='submit' onclick=\"return confirm('Delete this Project?')\">Delete</button>
            </form>
          </td>";
    echo "</tr>";
}
?>
</table>
</div>

</body>
</html>

<?php $conn->close(); ?>