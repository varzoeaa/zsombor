<?php
// kell hogy auth legyen a használó 
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard </title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
        <p>Hey, <?php echo $_SESSION['username']; ?>!</p>
        <p><a href="logout.php">Logout</a></p>
</body>
</html>