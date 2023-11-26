<?php
    session_start();

    // sikerült kijelentkezni
    if(session_destroy()) {
        echo "<div class='form'>
              <h3>You have been logged out successfully.</h3><br/>
              <p class='link'>Click here to <a href='login.php'>Login</a></p>
              </div>";
    } else {
        // nem sikerült kijelentkezni
        echo "<div class='form'>
              <h3>Logout failed. Please try again.</h3><br/>
              <p class='link'>Click here to <a href='login.php'>Login</a></p>
              </div>";
    }
?>