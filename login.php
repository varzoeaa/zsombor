<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('db.php');

    if (isset($_POST['submit'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $password = md5($password);

        $query = "SELECT * FROM `users` WHERE username='$username' AND password='$password'";
        $result = mysqli_query($con, $query) or die(mysqli_error($con));
        $rows = mysqli_num_rows($result);

        if ($rows == 1) {
            // sikeres login
            echo "<div class='form'>
                  <h3>Login successful. Welcome, $username!</h3><br/>
                  <p class='link'>Click here to <a href='logout.php'>Logout</a></p>
                  </div>";
        } else {
            // elbaszott login
            echo "<div class='form'>
                  <h3>Username or password is incorrect.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Login</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="password" class="login-input" name="password" placeholder="Password" required />
        <input type="submit" name="submit" value="Login" class="login-button">
        <p class="link"><a href="registration.php">Click to Register</a></p>
    </form>
<?php
    }
?>
</body>
</html>