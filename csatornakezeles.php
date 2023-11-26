<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin felület</title>
</head>

<body>

<h1>Csatorna kezelése</h1>

<?php
require('db_connect.php');

// Összegyűjtjük a műsorokat
$query = "SELECT * FROM csatorna";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Nem lehetséges előhívni a csatornákat." . mysqli_error($con);
    exit;
}
?>

<!-- Itt tudja kiválasztani a user, hogy mit szeretne tenni a csatornákkal -->
<form method="post" action="">
    <label for="csatorna">Válasszon csatornát</label>
    <select name="csatorna_id" id="csatorna_id" required>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?php echo $row['csatorna_id']; ?>"><?php echo $row['nev']; ?></option>
        <?php endwhile; ?>

    </select>
    <input type="submit" name="modify" value="Módosítás">
    <input type="submit" name="delete" value="Törlés">
    <input type="submit" name="add" value="Hozzáadás">
</form>

<?php
// csatorna választás feldolgozása
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csatorna_id'])) {
    $selected_csatorna_id = mysqli_real_escape_string($con, $_POST['csatorna_id']);

    // Kiválasztott csatorna 
    $query = "SELECT * FROM csatorna WHERE csatorna_id = $selected_csatorna_id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "Nem lehet előhívni a műsor részleteit." . mysqli_error($con);
        exit;
    }

    $csatorna = mysqli_fetch_assoc($result);

    // Form hogy beírja a user az updateket vagy a törlést, hozzáadást
    echo "<form method='post' action=''>
    <input type='hidden' name='selected_csatorna_id' value='$selected_csatorna_id'>
    <label for='nev'>Név:</label>
    <input type='text' id='nev' name='nev' value='{$csatorna['nev']}' required>
    
    <label for='kategoria'>Kategória:</label>
    <input type='text' id='kategoria' name='kategoria' value='{$csatorna['kategoria']}' required>
    
    <label for='leiras'>Ismertető:</label>
    <textarea id='leirás' name='leirás' required>{$csatorna['leirás']}</textarea>
    
    <input type='submit' name='modify' value='Módosítás'>
    <input type='submit' name='delete' value='Törlés'>
    </form>";
}

// Form feldolgozása 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_csatorna_id = mysqli_real_escape_string($con, $_POST['selected_csatorna_id']);
    $nev = mysqli_real_escape_string($con, $_POST['nev']);
    $kategoria = mysqli_real_escape_string($con, $_POST['kategoria']);
    $leiras = mysqli_real_escape_string($con, $_POST['leiras']);

    if (isset($_POST['modify'])) {
        // csatorna tábla updatelése az adatbázisban
        $query = "UPDATE csatorna
                  SET nev='$nev', kategoria='$kategoria', leiras='$leiras'
                  WHERE csatorna_id = $selected_csatorna_id";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<div>
                  <h3>Műsor sikeresen módosítva.</h3>
                  </div>";
        } else {
            echo "<div>
                  <h3>Hiba lépett fel. Próbáld újra!</h3>
                  </div>";
        }
    } elseif (isset($_POST['delete'])) {
        // csatorna törlése az adatbázisból
        $query = "DELETE FROM csatorna WHERE csatorna_id = $selected_csatorna_id";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<div>
                  <h3>Műsor sikeresen törölve.</h3>
                  </div>";
        } else {
            echo "<div>
                  <h3>Hiba lépett fel a törlés során. Próbáld újra!</h3>
                  </div>";
        }
    } elseif (isset($_POST['add'])) {
        // csatorna hozzáadása az adatbázishoz
        $query = "INSERT INTO csatorna (nev, kategoria, ismerteto)
                  VALUES ('$nev', '$epizod', '$ismerteto')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<div>
                  <h3>Műsor sikeresen hozzáadva.</h3>
                  </div>";
        } else {
            echo "<div>
                  <h3>Hiba lépett fel a hozzáadás során. Próbáld újra!</h3>
                  </div>";
        }
    }
}
?>

</body>
</html>



