<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin felület</title>
</head>

<body>

<h1>Műsor kezelése</h1>

<?php
require('db.php');

// Összegyűjtjük a műsorokat
$query = "SELECT * FROM musor";
$result = mysqli_query($con, $query);

if (!$result) {
    echo "Nem lehetséges előhívni a műsorokat." . mysqli_error($con);
    exit;
}
?>

<!-- Itt tudja kiválasztani a user, hogy mit szeretne tenni a műsorokkal -->
<form method="post" action="">
    <label for="musor">Válasszon műsort</label>
    <select name="musor_id" id="musor_id" required>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <option value="<?php echo $row['musor_id']; ?>"><?php echo $row['nev']; ?></option>
        <?php endwhile; ?>

    </select>
    <input type="submit" name="modify" value="Módosítás">
    <input type="submit" name="delete" value="Törlés">
    <input type="submit" name="add" value="Hozzáadás">
</form>

<?php
// műsor választás feldolgozása
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['musor_id'])) {
    $selected_musor_id = mysqli_real_escape_string($con, $_POST['musor_id']);

    // Kiválasztott musor 
    $query = "SELECT * FROM musor WHERE musor_id = $selected_musor_id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "Nem lehet előhívni a műsor részleteit." . mysqli_error($con);
        exit;
    }

    $musor = mysqli_fetch_assoc($result);

    // Form hogy beírja a user az updateket vagy a törlést, hozzáadást
    echo "<form method='post' action=''>
    <input type='hidden' name='selected_musor_id' value='$selected_musor_id'>
    <label for='nev'>Név:</label>
    <input type='text' id='nev' name='nev' value='{$musor['nev']}' required>
    
    <label for='epizod'>Epizód:</label>
    <input type='text' id='epizod' name='epizod' value='{$musor['epizod']}' required>
    
    <label for='ismerteto'>Ismertető:</label>
    <textarea id='ismerteto' name='ismerteto' required>{$musor['ismerteto']}</textarea>
    
    <input type='submit' name='modify' value='Módosítás'>
    <input type='submit' name='delete' value='Törlés'>
    </form>";
}

// Form feldolgozása 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_musor_id = mysqli_real_escape_string($con, $_POST['selected_musor_id']);
    $nev = mysqli_real_escape_string($con, $_POST['nev']);
    $epizod = mysqli_real_escape_string($con, $_POST['epizod']);
    $ismerteto = mysqli_real_escape_string($con, $_POST['ismerteto']);

    if (isset($_POST['modify'])) {
        // Musor tábla updatelése az adatbázisban
        $query = "UPDATE musor
                  SET nev='$nev', epizod='$epizod', ismerteto='$ismerteto'
                  WHERE musor_id = $selected_musor_id";
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
        // Musor törlése az adatbázisból
        $query = "DELETE FROM musor WHERE musor_id = $selected_musor_id";
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
        // műsor hozzáadása az adatbázishoz
        $query = "INSERT INTO musor (nev, epizod, ismerteto)
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



