<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Regisztráció</title>
    <link rel="stylesheet" href="style.css"/>
</head>

<body>

<?php
require('db_connect.php');

if (isset($_POST['submit'])) {
    // Backend registration logic
    $felh_nev = stripslashes($_POST['username']);
    $felh_nev = mysqli_real_escape_string($con, $felh_nev);
    $email    = stripslashes($_POST['email']);
    $email    = mysqli_real_escape_string($con, $email);
    $password = stripslashes($_POST['password']);
    $password = mysqli_real_escape_string($con, $password);
    $confirm_password = stripslashes($_POST['confirm_password']);
    $confirm_password = mysqli_real_escape_string($con, $confirm_password);

    if ($password == $confirm_password) {
        $create_datetime = date("Y-m-d H:i:s");
        $hashed_password = md5($password);
        $admin = isset($_POST['admin']) ? 1 : 0;

        $query = "INSERT into `felhasznalo` (felh_nev, password, email, admin, create_datetime)
                  VALUES ('$felh_nev', '$hashed_password', '$email', $admin, '$create_datetime')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<div class='form'>
                  <h3>Sikeresen reisztráltál!</h3><br/>
                  <p class='link'>Kattints ide, hogy <a href='login.php'>Bejelentkezz!</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Hiba lépett fel a regisztráció során.</h3><br/>
                  <p class='link'>Kattints ide, hogy <a href='registration.php'>Regisztrálj!</a> újra.</p>
                  </div>";
        }
    } else {
        echo "<div class='form'>
              <h3>A jelszavak nem egyeznek</h3><br/>
              <p class='link'>Kattints ide, hogy <a href='registration.php'>Regisztrálj!</a> újra.</p>
              </div>";
    }
} 
?>

<!-- Frontend registration form -->
<form class="form" action="" method="post">
    <h1 class="login-title">Regisztráció</h1>
    <input type="text" class="login-input" name="username" placeholder="Username" required />
    <input type="text" class="login-input" name="email" placeholder="Email Address">
    <input type="password" class="login-input" name="password" placeholder="Password" required />
    <input type="password" class="login-input" name="confirm_password" placeholder="Confirm Password" required />
    <label for="admin">Regisztráció adminként</label>
    <input type="checkbox" name="admin" id="admin" value="1">
    <input type="submit" name="submit" value="Register" class="login-button">
    <p class="link"><a href="login.php">Jelentkezz be!</a></p>
</form>

</body>
</html>