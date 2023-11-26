<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    require('.php');    // valami file amiben benne van a code a csatlakozáshoz a dbhez

    if (isset($_REQUEST['username'])) {
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $confirm_password = stripslashes($_REQUEST['confirm_password']);
        $confirm_password = mysqli_real_escape_string($con, $confirm_password);

        // matchelő jelszó
        if ($password == $confirm_password) {
            $create_datetime = date("Y-m-d H:i:s");
            $hashed_password = md5($password);

            $query = "INSERT into `users` (username, password, email, create_datetime)
                      VALUES ('$username', '$hashed_password', '$email', '$create_datetime')";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo "<div class='form'>
                      <h3>You are registered successfully.</h3><br/>
                      <p class='link'>Click here to <a href='login.php'>Login</a></p>
                      </div>";
            } else {
                echo "<div class='form'>
                      <h3>Failed to register. Please try again.</h3><br/>
                      <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                      </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>Passwords do not match. Please try again.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>";
        }
        else {
?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Registration</h1>
        <input type="text" class="login-input" name="username" placeholder="Username" required />
        <input type="text" class="login-input" name="email" placeholder="Email Address">
        <input type="password" class="login-input" name="password" placeholder="Password" required />
        <input type="password" class="login-input" name="confirm_password" placeholder="Confirm Password" required />
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="login.php">Click to Login</a></p>
    </form>
<?php
    }
?>
</body>
</html>