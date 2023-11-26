<?php
// kell hogy auth legyen a használó 
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vezérlőpult </title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
        <h1>Hey, <?php echo $_SESSION['username']; ?>!</h1>


<!-- írassa ki a felhasználó által kiválasztott csatorna adatait -->
<h2>Csatorna adatok</h2>


<!-- felhasználó input a csatorna kiválasztásához -->
<form method="post" action="">
    <label for="csatorna_nev">Válasszon csatornát:</label>
    <input type="text" id="csatorna_nev" name="csatorna_nev" required>
    <input type="submit" name="submit" value="Keresés">
</form>

<?php
// adatbázis kapcsolat
require('db_connect.php');

// felh input feldolgozá és csatorna adatok
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csatorna_nev'])) {
    $csatorna_nev = mysqli_real_escape_string($con, $_POST['csatorna_nev']);

    // SQL query
    $query = "SELECT cs.nev AS 'Csatorna Név', cs.kategoria AS 'Kategoria', cs.leiras AS 'Leírás'
              FROM csatorna cs
              WHERE cs.nev = '$csatorna_nev'";
    
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "Hiba a lekérdezés során: " . mysqli_error($con);
    } else {
        // Display results in a table
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Eredmény:</h2>";
            echo "<table border='1'>";
            $row = mysqli_fetch_assoc($result);
            foreach ($row as $key => $value) {
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nincs találat a megadott csatornára.</p>";
        }
    }
}
?>

<!-- listázza ki táblázatosan a felhasználó által megadott napon a kereskedelmi 
kategóriájú csatornák műsorkínálatát időrendben -->
<h2>Közvetítések keresése</h2>


<!-- felh input nap választás -->
<form method="post" action="">
    <label for="megadott_nap">Válasszon napot:</label>
    <input type="date" id="megadott_nap" name="megadott_nap" required>
    <input type="submit" name="submit" value="Keresés">
</form>

<?php
require('db_connect.php');

// feldolgozni user inputot 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['megadott_nap'])) {
    $megadott_nap = mysqli_real_escape_string($con, $_POST['megadott_nap']);

    // SQL query
    $query = "SELECT cs.nev AS 'Csatorna név', m.cim AS 'Műsor cím', k.idopont
              FROM kozvetites k
              INNER JOIN csatorna cs ON cs.csatorna_id = k.csatorna_id
              INNER JOIN musor m ON m.musor_id = k.musor_id
              WHERE DATE(k.idopont) = '$megadott_nap'
              AND cs.kategoria = 'kereskedelmi'
              ORDER BY k.idopont DESC";
    
    $result = mysqli_query($con, $query);

    if (!$result) {
        echo "Hiba a lekérdezés során: " . mysqli_error($con);
    } else {
        if (mysqli_num_rows($result) > 0) {
            echo "<h2>Eredmény:</h2>";
            echo "<table border='1'>";

            echo "<tr><th>Csatorna név</th><th>Műsor cím</th><th>Időpont</th></tr>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr><td>{$row['Csatorna név']}</td><td>{$row['Műsor cím']}</td><td>{$row['idopont']}</td></tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nincs találat a megadott napra vagy a kereskedelmi kategóriába tartozó műsorokra.</p>";
        }
    }
}
?>

<!-- listázza ki ABC sorrendben a felhasználó által kiválasztott 
műsor szereplőinek összes adatait -->
<h2>Műsorok száma csatornánként</h2>

<?php
require('db_connect.php');

// SQL query
$query = "SELECT cs.nev AS 'Csatorna név', COUNT(m.musor_id) AS 'Műsorok száma', ma.nev AS 'Műsor név'
          FROM csatorna cs
          JOIN musorok m ON cs.csatorna_id = m.csatorna_id
          JOIN musor ma ON m.musor_id = ma.musor_id
          WHERE DATE(m.idopont) = CURDATE()
          GROUP BY cs.csatorna_id
          HAVING COUNT(m.musor_id) >= 10";

$result = mysqli_query($con, $query);

if (!$result) {
    echo "Hiba a lekérdezés során: " . mysqli_error($con);
} else {
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Eredmény:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Csatorna név</th><th>Műsorok száma</th><th>Műsor név</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['Csatorna név']}</td><td>{$row['Műsorok száma']}</td><td>{$row['Műsor név']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nincs találat a mai napra vagy a feltételeknek megfelelő csatornákra.</p>";
    }
}
?>


<!-- listázza ki, hogy (rendszerdátum szerint) ma melyik csatornán
vetítenek legalább 10 műsort, ha ugyanazon műsor ismétlését 
egy napon belül nem vesszük figyelembe a számításnál -->
<h1>Műsorok száma csatornánként Ma</h1>


<?php
require('db_connect.php');

// SQL query
$query = "SELECT cs.nev AS 'Csatorna név', COUNT(DISTINCT m.musor_id) AS 'Műsorok száma', ma.nev AS 'Műsor név'
          FROM csatorna cs
          JOIN musorok m ON cs.csatorna_id = m.csatorna_id
          JOIN musor ma ON m.musor_id = ma.musor_id
          WHERE DATE(m.idopont) = CURDATE()
          GROUP BY cs.csatorna_id
          HAVING COUNT(DISTINCT m.musor_id) >= 10";

$result = mysqli_query($con, $query);

if (!$result) {
    echo "Hiba a lekérdezés során: " . mysqli_error($con);
} else {
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Eredmény:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Csatorna név</th><th>Műsorok száma</th><th>Műsor név</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['Csatorna név']}</td><td>{$row['Műsorok száma']}</td><td>{$row['Műsor név']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nincs találat a mai napra vagy a feltételeknek megfelelő csatornákra.</p>";
    }
}
?>



<!-- listázza ki, hogy az ugyanolyan nemzetiségű szereplők közül 
kik a legfiatalabb szereplők (nemzetiségenként)! -->
<h1>Legfiatalabb szereplők nemzetiségenként</h1>

<?php
require('db_connect.php');

// SQL query
$query = "SELECT
            sz.nemzetiseg AS 'Nemzetiség',
            MIN(sz.sz_nev) AS 'Szereplő neve',
            MIN(sz.szul_datum) AS 'Legfiatalabb szereplő'
          FROM szereplo sz
          GROUP BY sz.nemzetiseg";

$result = mysqli_query($con, $query);

if (!$result) {
    echo "Hiba a lekérdezés során: " . mysqli_error($con);
} else {
    if (mysqli_num_rows($result) > 0) {
        echo "<h2>Eredmény:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nemzetiség</th><th>Szereplő neve</th><th>Legfiatalabb szereplő</th></tr>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr><td>{$row['Nemzetiség']}</td><td>{$row['Szereplő neve']}</td><td>{$row['Legfiatalabb szereplő']}</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nincs találat a feltételeknek megfelelő szereplőkre.</p>";
    }
}
?>

        <p><a href="logout.php">Kijelentkezés</a></p>
</body>
</html>







