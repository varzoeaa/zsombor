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
require('db_connect.php');

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
            <option value="<?php echo $row['musor_id']; ?>"><?php echo $row['cim']; ?></option>
        <?php endwhile; ?>

    </select>
    <input type="submit" name="modify" value="Módosítás">
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

    // Form hogy beírja a user az updatet az ismertetőhöz
    echo "<form method='post' action=''>
    <input type='hidden' name='selected_musor_id' value='$selected_musor_id'>
    <label for='ismerteto'>Ismertető:</label>
    <textarea id='ismerteto' name='ismerteto' required>{$musor['ismerteto']}</textarea>
    
    <input type='submit' name='modify' value='Módosítás'>
    </form>";
}

// Form feldolgozása 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modify'])) {
    $selected_musor_id = mysqli_real_escape_string($con, $_POST['selected_musor_id']);
    $ismerteto = mysqli_real_escape_string($con, $_POST['ismerteto']);

    // Musor tábla updatelése az adatbázisban
    $query = "UPDATE musor
              SET ismerteto='$ismerteto'
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
}



// Form új műsorhoz 
echo "<form method='post' action=''>
    <label for='new_cim'>Új műsor cím:</label>
    <input type='text' id='new_cim' name='new_cim' required>

    <label for='new_epizod'>Új epizód:</label>
    <input type='text' id='new_epizod' name='new_epizod' required>

    <label for='new_ismerteto'>Új ismertető:</label>
    <textarea id='new_ismerteto' name='new_ismerteto' required></textarea>

    <input type='submit' name='add' value='Hozzáadás'>
</form>";

// Form feldolgozása
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $new_cim = mysqli_real_escape_string($con, $_POST['new_cim']);
    $new_epizod = mysqli_real_escape_string($con, $_POST['new_epizod']);
    $new_ismerteto = mysqli_real_escape_string($con, $_POST['new_ismerteto']);

    // musor tábla hozzáadása az adatbázishoz
    $query = "INSERT INTO musor (cim, epizod, ismerteto)
              VALUES ('$new_cim', '$new_epizod', '$new_ismerteto')";
    $result = mysqli_query($con, $query);

    if ($result) {
        echo "<div>
              <h3>Új műsor sikeresen hozzáadva.</h3>
              </div>";
    } else {
        echo "<div>
              <h3>Hiba lépett fel a hozzáadás során. Próbáld újra!</h3>
              </div>";
    }
}

// szereplő, csatorna, időpont hozzárendelése műsorhoz
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cim = mysqli_real_escape_string($con, $_POST['cim']);
    $nev = mysqli_real_escape_string($con, $_POST['nev']);
    $sz_nev = mysqli_real_escape_string($con, $_POST['sz_nev']);
    $idopont = mysqli_real_escape_string($con, $_POST['idopont']);

    if (isset($_POST['add'])) {

        // Kozvetites table hozzáadása az adatbázishoz
        $query = "INSERT INTO kozvetites (koz_id, musor_id, csatorna_id, szerep_id, idopont)
        SELECT  m.musor_id, cs.csatorna_id, szerep_id, new_koz.idopont
        FROM (
            SELECT $cim AS cim, $nev AS nev, $sz_nev AS sz_nev, $idopont AS idopont
            ) AS new_mus
        INNER JOIN musor m ON m.cim = new_mus.cim 
        INNER JOIN csatorna cs ON cs.nev = new_mus.nev
        INNER JOIN szereplo sz ON sz.sz_nev = new_mus.sz_nev;";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<div>
                  <h3>Közvetítés sikeresen hozzáadva.</h3>
                  </div>";
        } else {
            echo "<div>
                  <h3>Hiba lépett fel a hozzáadás során. Próbáld újra!</h3>
                  </div>";
        }
    }
}
?>

<!-- form -->
<form method="post" action="">
    <h1>Műsor hozzárendelés:</h1>

    <label for="cim">Műsor Cím:</label>
    <input type="text" id="cim" name="cim" required>

    <label for="nev">Csatorna Név:</label>
    <input type="text" id="nev" name="nev" required>

    <label for="nev">Szereplő Név:</label>
    <input type="text" id="nev" name="nev" required>

    <label for="idopont">Időpont:</label>
    <input type="datetime-local" id="idopont" name="idopont" required>

    <input type="submit" name="add" value="Hozzáad">
</form>



?>

</body>
</html>

