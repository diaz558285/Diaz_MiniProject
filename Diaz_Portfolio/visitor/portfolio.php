<?php
require_once '../config/db.php';  

$skills = $conn->query("SELECT * FROM Skills_Tbl ORDER BY Skill_ID ASC")->fetch_all(MYSQLI_ASSOC);
$experiences = $conn->query("SELECT * FROM Experiences_Tbl ORDER BY Start_Date DESC")->fetch_all(MYSQLI_ASSOC);
$projects = $conn->query("SELECT * FROM Projects_Tbl ORDER BY Project_ID ASC")->fetch_all(MYSQLI_ASSOC);
 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visitor- Portfolio Page</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <nav class="navbar">
        <a href="portfolio.php">Portfolio</a>
        <a href="contact.php">Contact</a>
        <a href="../logout.php">Logout</a>
    </nav>

    <div class="portfolio-container">

    <h1>Welcome to My Portfolio!</h1>

    <img class="profile-img"
    src ="../images/diaz.jpg" 
    alt = "Profile picture placeholder" width="200" height="200">
    <br><br>

    <div>
        <h2>About Me</h2>
        <p>
            Hello! My name is <strong>Elyza Bianca Diaz</strong>.
            I am a second-year college student currently taking a <em>Bachelor of Science in Information Technology </em> program at the University of Mindanao.
            I am passionate about learning new technologies and continuously improving my skills.
        </p>

        <p>
            I believe that willingness to learn, perseverance, discipline, hard work, and consistency
            are essential in achieving personal and professional growth. 
        </p>

    </div>
    

    <hr>

    <h2>My Skills</h2>
    <ul>
      <?php foreach($skills as $skill): ?>
      <li><?php echo $skill['Skill_Name'] . " (" . $skill['Skill_Level'] . ")"; ?></li>
      <?php endforeach; ?>
    </ul><br>
    <hr>

    <h2>My Experiences</h2>
    <ul>
      <?php foreach($experiences as $exp): ?>
      <li>
         <div class="project-card">
        <strong><?php echo $exp['Title']; ?></strong> at <?php echo $exp['Company']; ?>  
        (<?php echo $exp['Start_Date']; ?> - <?php echo $exp['End_Date'] ?: "Present"; ?>)
        <br>
        <?php echo $exp['Description']; ?>
      </li>
    <?php endforeach; ?>
    </ul><br>
    <hr>

    <h2>My Projects</h2>
      <?php foreach($projects as $proj): ?>
      <div class="project-card">
      <h3><?php echo $proj['Title']; ?></h3>
      <p><?php echo $proj['Description']; ?></p>

      <?php if($proj['Link']): ?>
        <p>Link: <a href="<?php echo $proj['Link']; ?>" target="_blank"><?php echo $proj['Link']; ?></a></p>
      <?php endif; ?>

     <?php if($proj['Project_Image']): ?>
      <img width="200" src="data:images/jpeg;base64,<?php echo base64_encode($proj['Project_Image']); ?>" alt="<?php echo $proj['Title']; ?>">
     <?php endif; ?>

    </div>
    <?php endforeach; ?>
 
    <br><br>
    </div>
    

</body>
</html>