<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Műsor hozzáadása</title>
</head>
<body>
<?php
    // db connection
    require('.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // adatok a táblához
        $cim = mysqli_real_escape_string($con, $_POST['cim']);
        $epizod = mysqli_real_escape_string($con, $_POST['epizod']);
        $ismerteto = mysqli_real_escape_string($con, $_POST['ismerteto']);

        // Insert into db
        $query = "INSERT INTO schema_name.musor (cim, epizod, ismerteto) 
                  VALUES ('$cim', '$epizod', '$ismerteto')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<div>
                  <h3>Műsor sikeresen hozzáadva.</h3>
                  </div>";
        } else {
            echo "<div>
                  <h3>Nem sikerült hozzáadni, kréelk próbáld újra!</h3>
                  </div>";
        }
    }
?>

<form method="post" action="">
    <label for="cim">Cím:</label>
    <input type="text" id="cim" name="cim" required>

    <label for="epizod">Epizod:</label>
    <input type="text" id="epizod" name="epizod" required>

    <label for="ismertető">Ismertető:</label>
    <input type="date" id="ismerteto" name="ismertető" required>

    <input type="submit" value="add musor">
</form>

</body>
</html>
