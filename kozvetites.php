<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admin felület</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    require('db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cim = mysqli_real_escape_string($con, $_POST['cim']);
        $nev = mysqli_real_escape_string($con, $_POST['nev']);
        $sz_nev = mysqli_real_escape_string($con, $_POST['sz_nev']);
        $idopont = mysqli_real_escape_string($con, $_POST['idopont']);

        if (isset($_POST['add'])) {

            // Kozvetites table hozzáadása az adatbázishoz
            $query = "INSERT INTO kozvetites (musor_id, csatorna_id, szerep_id, idopont)
            SELECT m.musor_id, cs.csatorna_id, sz.szerep_id, new_koz.idopont
            FROM (
                SELECT $cim AS cim, $nev AS nev, $sz_nev AS sz_nev, $idopont AS idopont
                ) AS new_koz
            INNER JOIN musor m ON m.cim = new_koz.cim 
            INNER JOIN csatorna cs ON cs.nev = new_koz.nev
            INNER JOIN szereplo sz ON sz.sz_nev = new_koz.sz_nev;";
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
        <h1>Közvetítés hozzáadása</h1>

        <!-- Dropdown/select inputs for cim, nev, and sz_nev -->
        <label for="cim">Műsor Cím:</label>
        <input type="text" id="cim" name="cim" required>

        <label for="nev">Csatorna Név:</label>
        <input type="text" id="nev" name="nev" required>

        <label for="sz_nev">Szereplő Név:</label>
        <input type="text" id="sz_nev" name="sz_nev" required>

        <label for="idopont">Időpont:</label>
        <input type="datetime-local" id="idopont" name="idopont" required>

        <input type="submit" name="add" value="Hozzáad">
    </form>

</body>

</html>









































<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admin felület</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    require('db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $musor_id = mysqli_real_escape_string($con, $_POST['musor_id']);
        $csatorna_id = mysqli_real_escape_string($con, $_POST['csatorna_id']);
        $szerep_id = mysqli_real_escape_string($con, $_POST['szerep_id']);
        $idopont = mysqli_real_escape_string($con, $_POST['idopont']);

        if (isset($_POST['add'])) {
            // Kozvetites tábla hozzáadása az adatbázishoz
            $query = "INSERT INTO kozvetites (musor_id, csatorna_id, szerep_id, idopont)
            SELECT m.musor_id, cs.csatorna_id, sz.szerep_id, new_koz.idopont
            FROM (
                SELECT $cim AS cim, $nev AS nev, $sz_nev AS sz_nev, $idopont AS idopont
                ) AS new_koz
            INNER JOIN musor m ON m.cim = new_koz.cim 
            INNER JOIN csatorna cs ON cs.nev = new_koz.nev
            INNER JOIN szereplo sz ON sz.sz_nev = new_koz.sz_nev;

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

    <!-- Form for adding entries to the kozvetites table -->
    <form method="post" action="">
        <h1>Közvetítés hozzáadása</h1>

        <!-- You can replace these input fields with the appropriate dropdowns or input types based on your requirements -->
        <label for="musor_id">Műsor ID:</label>
        <input type="text" id="musor_id" name="musor_id" required>

        <label for="csatorna_id">Csatorna ID:</label>
        <input type="text" id="csatorna_id" name="csatorna_id" required>

        <label for="szerep_id">Szerep ID:</label>
        <input type="text" id="szerep_id" name="szerep_id" required>

        <label for="idopont">Időpont:</label>
        <input type="datetime-local" id="idopont" name="idopont" required>

        <input type="submit" name="add" value="Hozzáad">
    </form>

</body>

</html>









<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Admin felület</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    require('db_connect.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cim = mysqli_real_escape_string($con, $_POST['cim']);
        $nev = mysqli_real_escape_string($con, $_POST['nev']);
        $sz_nev = mysqli_real_escape_string($con, $_POST['sz_nev']);
        $idopont = mysqli_real_escape_string($con, $_POST['idopont']);

        if (isset($_POST['add'])) {

            // Kozvetites table hozzáadása az adatbázishoz
            $query = "INSERT INTO kozvetites (musor_id, csatorna_id, szerep_id, idopont)
            SELECT m.musor_id, cs.csatorna_id, sz.szerep_id, new_koz.idopont
            FROM (
                SELECT $cim AS cim, $nev AS nev, $sz_nev AS sz_nev, $idopont AS idopont
                ) AS new_koz
            INNER JOIN musor m ON m.cim = new_koz.cim 
            INNER JOIN csatorna cs ON cs.nev = new_koz.nev
            INNER JOIN szereplo sz ON sz.sz_nev = new_koz.sz_nev;
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



    <!-- Form for adding entries to the kozvetites table -->
    <form method="post" action="">
        <h1>Közvetítés hozzáadása</h1>

        <!-- Dropdown/select inputs for cim, nev, and sz_nev -->
        <label for="cim">Műsor Cím:</label>
        <select id="cim" name="cim" required>
            <?php
            $musor_query = "SELECT cim FROM musor";
            $musor_result = mysqli_query($con, $musor_query);

            while ($row = mysqli_fetch_assoc($musor_result)) {
                echo "<option value='" . $row['cim'] . "'>" . $row['cim'] . "</option>";
            }
            ?>
        </select>

        <label for="nev">Csatorna Név:</label>
        <select id="nev" name="nev" required>
            <?php
            $csatorna_query = "SELECT nev FROM csatorna";
            $csatorna_result = mysqli_query($con, $csatorna_query);

            while ($row = mysqli_fetch_assoc($csatorna_result)) {
                echo "<option value='" . $row['nev'] . "'>" . $row['nev'] . "</option>";
            }
            ?>
        </select>

        <label for="sz_nev">Szereplő Név:</label>
        <select id="sz_nev" name="sz_nev" required>
            <?php
            $szerep_query = "SELECT sz_nev FROM szereplo";
            $szerep_result = mysqli_query($con, $szerep_query);

            while ($row = mysqli_fetch_assoc($szerep_result)) {
                echo "<option value='" . $row['sz_nev'] . "'>" . $row['sz_nev'] . "</option>";
            }
            ?>
        </select>

        <label for="idopont">Időpont:</label>
        <input type="datetime-local" id="idopont" name="idopont" required>

        <input type="submit" name="add" value="Hozzáad">
    </form>

</body>

</html>