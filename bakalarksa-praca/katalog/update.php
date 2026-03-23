<?php
include("../includes/dbh.php");


$id_to_update = $_GET['id'];
$query = "SELECT * FROM produkty WHERE ID='$id_to_update'";
$result = mysqli_query($conn, $query);


if (isset($_POST['Edit'])) {
    @$updateNazov = $_POST['Nazov'];
    @$updateKategoria = $_POST['Kategoria'];
    @$updateTyp = $_POST['Typ'];
    @$updateCena = $_POST['Cena'];
    @$updateFarba = $_POST['Farba'];
    @$updateObrazok_path = $_POST['Obrazok_path'];
    @$updatePohlavie = $_POST['Pohlavie'];
}


while ($row = mysqli_fetch_array($result)) {
    $Nazov = $row['Nazov'];
    $Kategoria = $row['Kategoria'];
    $Typ = $row['Typ'];
    $Cena = $row['Cena'];
    $Farba = $row['Farba'];
    $Obrazok_path = $row['Obrazok_path'];
    $Pohlavie = $row['Pohlavie'];
}

if (isset($_POST['Edit'])) {

    $query1 = "UPDATE produkty SET Nazov='$updateNazov', Kategoria='$updateKategoria', Typ='$updateTyp',
           Cena='$updateCena', Farba='$updateFarba', Obrazok_path='$updateObrazok_path'
           , Pohlavie='$updatePohlavie' WHERE ID='$id_to_update';";

    $result1 = mysqli_query($conn, $query1);


    if (!$result1) {

        header("Location : update.php?chyba");
    } else {

        header("Location: sprava_produktov.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creatorshop</title>
    <link rel="stylesheet" href="../css/update.css">
</head>

<body>
    <div class="container">
        <header>
            <div class="top-bar">
                <div class="prva-casť">
                    <ul class="ul-item-menu">
                        <li class="li-item-menu-logo">
                            <a href="katalog.php" class="a-logo">
                                <h1 class="h1-logo">Správa produktov</h1>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="druha-casť">
                    <ul class="ul-item-menu">

                    </ul>
                </div>
            </div>
        </header>
        <hr>
        <main>
            <div class="uprava">
                <ul class="uprava-ul">
                    <form action="" method="post">
                        <li class="uprava-li">
                            <label class="uprava-label">Názov</label>
                            <input type="text" name="Nazov" placeholder="Názov" value="<?php echo $Nazov; ?>" class="text" required>
                        </li>
                        <li class="uprava-li">
                            <label class="uprava-label">Kategória</label>
                            <div class="custom-select">
                                <select name="Kategoria">
                                    <option value="<?php echo $Kategoria; ?>"><?php echo $Kategoria; ?></option>
                                    <?php
                                    $sql = "SELECT * FROM kategoria";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row["Nazov_kategorie"] . '"> ' . $row["Nazov_kategorie"] . '</option>';
                                        }
                                    } else {
                                        echo  '<option value="0">Nie je vytvorená žiadna kategória</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li class="uprava-li">
                            <label class="uprava-label">Typ</label>
                            <div class="custom-select">
                                <select name="Typ">
                                    <option value="<?php echo $Typ; ?>"><?php echo $Typ; ?></option>
                                    <?php

                                    $sql = "SELECT * FROM typy";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row["Nazov_typu"] . '"> ' . $row["Nazov_typu"] . '</option>';
                                        }
                                    } else {
                                        echo  '<option value="0">Nie je vytvorená žiadna kategória</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li class="uprava-li">
                            <label class="uprava-label">Farba</label>
                            <div class="custom-select">
                                <select name="Farba">
                                    <option value="<?php echo $Farba; ?>"><?php echo $Farba; ?></option>
                                    <?php

                                    $sql = "SELECT * FROM farby";
                                    $result = $conn->query($sql);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' . $row["Nazov_farby"] . '"> ' . $row["Nazov_farby"] . '</option>';
                                        }
                                    } else {
                                        echo  '<option value="0">Nie je vytvorená žiadna kategória</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </li>
                        <li class="uprava-li">
                            <label class="uprava-label">Cena</label>
                            <input type="text" name="Cena" placeholder="Cena" value="<?php echo $Cena; ?>" class="text" required>
                        </li>
                        <li class="uprava-li">
                            <label class="uprava-label">Pohlavie</label>
                            <input type="text" name="Pohlavie" placeholder="Pohlavie" value="<?php echo $Pohlavie; ?>" class="text" required>
                        </li>
                        <li class="uprava-li">
                            <label class="uprava-label">Obrázok</label>
                            <input type="file" name="Obrazok_path" placeholder="Obrázok" value="<?php echo $Obrazok_path; ?>">
                        </li>
                        <li class="li-item-menu">
                            <button type="sumbit" name="Edit" value="Edit" class="upravit">Upraviť</button>
                            <button onclick="goToHomePage()" type="button" class="upravit">Domov</button>
                        </li>
                    </form>
                </ul>
            </div>
        </main>
    </div>
    <script src="../javascript/update.js">
    </script>
</body>

</html>