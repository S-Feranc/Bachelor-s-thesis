<?php
include("../includes/dbh.php");
include("search.php");


if (isset($_SESSION["MAIL"])) {
    $Mail = $_SESSION["MAIL"];
    $result = mysqli_query($conn, "SELECT * FROM pouzivatelia WHERE Mail = '$Mail'");
    if ($row = mysqli_fetch_array($result)) {
        $ID = $row['ID'];
        if ($ID === '3') {
            $Nazov = @$_POST["Nazov"];
            $Kategoria = filter_input(INPUT_POST, 'Kategoria');
            $Typ = filter_input(INPUT_POST, 'Typ');
            $Cena = @$_POST["Cena"];
            $Farba = filter_input(INPUT_POST, 'Farba');
            $Obrazok_path = @$_POST["Obrazok_path"];
            $Pohlavie = @$_POST["Pohlavie"];
            $Nazov_farby = @$_POST["Nazov_farby"];
            $Farba_kod = @$_POST["Farba_kod"];
            $Nazov_kategorie = @$_POST["Nazov_kategorie"];
            $Nazov_typu = @$_POST["Nazov_typu"];


            /*  $category = filter_input(INPUT_POST, 'category');*/
            if (isset($_POST["add"])) {
                // Ensure that the selected options are not empty
                if ($Kategoria != 0 && $Typ != 0 && $Farba != 0) {
                    $querry = "INSERT INTO produkty(Nazov, Kategoria, Cena, Farba, Typ, Obrazok_path, Pohlavie)
                               VALUES ('$Nazov', '$Kategoria', '$Cena', '$Farba',  '$Typ', '$Obrazok_path', '$Pohlavie')";

                    $result = mysqli_query($conn, $querry);

                    if (!$result) {
                        die("Nepodarilo sa uložiť do databázy");
                    }

                    header("location: sprava_produktov.php");
                } else {
                    echo "Please select valid options for Kategoria, Typ, and Farba.";
                }
            }

            if (isset($_POST["add-kategoriu"])) {
                $querry = "INSERT INTO kategoria(Nazov_kategorie)
                VALUES ('$Nazov_kategorie')";

                $result = mysqli_query($conn, $querry);

                if (!$result) {
                    die("Nepodarilo sa uložiť do databázy");
                }

                header("location: sprava_produktov.php");
            }

            if (isset($_POST["add-typ"])) {
                // Ensure that the selected options are not empty

                $querry = "INSERT INTO typy(Nazov_typu)
                               VALUES ('$Nazov_typu')";

                $result = mysqli_query($conn, $querry);

                if (!$result) {
                    die("Nepodarilo sa uložiť do databázy");
                }

                header("location: sprava_produktov.php");
            }

            if (isset($_POST["add-farbu"])) {
                $querry = "INSERT INTO farby(Nazov_farby, farba)
                    VALUES ('$Nazov_farby', '$Farba_kod')";

                $result = mysqli_query($conn, $querry);

                if (!$result) {
                    die("Nepodarilo sa uložiť do databázy");
                }

                header("location: sprava_produktov.php");
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creatorshop</title>
    <link rel="stylesheet" href="../css/sprava_produktov.css">
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
                        <li class="li-item-menu">
                            <button onclick="goToHomePage()" type="button" class="odstranit">Domov</button>
                        </li>
                        <li class="li-item-menu">
                            <button onclick="document.getElementById('id05').style.display='block'" type="button" class="odstranit">Pridať produkt</button>
                        </li>
                        <li class="li-item-menu">
                            <button onclick="document.getElementById('id06').style.display='block'" type="button" class="odstranit">Pridať Kategóriu</button>
                        </li>
                        <li class="li-item-menu">
                            <button onclick="document.getElementById('id07').style.display='block'" class="odstranit">Pridať typ</button>
                        </li>
                        <li class="li-item-menu">
                            <button onclick="document.getElementById('id08').style.display='block'" type="button" class="odstranit">Pridať farbu</button>
                        </li>
                    </ul>
                </div>
                <div class="tretia-casť uprava3">
                    <form action="" method="post">
                        <ul class="ul-item-menu">
                            <li class="li-item-menu-search-line ">
                                <input class="button-search-line " name="valueToSearch" type="search" placeholder="Hladať" aria-label="Search">
                                <input type="submit" name="search" value="" class="btn-search ">
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </header>
        <hr>
        <main>
            <form class="tabulka-form" action="delete.php" method="post">
                <table class="listok">
                    <caption>
                        <h2 class="produkty-nadpis-tabulka">Produkty</h2>
                    </caption>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Názov</th>
                        <th>Kategória</th>
                        <th>Typ</th>
                        <th>Cena</th>
                        <th>Farba</th>
                        <th>Pohlavie</th>
                        <th>Obrázok</th>
                        <th></th>
                    </tr>

                    <?php while ($row = mysqli_fetch_array($search_result)) :
                        $id_to_update = $row['ID'];
                        $updateNazov = $row['Nazov'];
                        $updateKategoria =   $row['Kategoria'];
                        $updateTyp =   $row['Typ'];
                        $updateCena = $row['Cena'];
                        $updateFarba =  $row['Farba'];
                        $updateObrazok_path = $row['Obrazok_path'];
                        $updatePohlavie = $row['Pohlavie']; ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="delete_ids[]" value="<?php echo $row['ID']; ?>" class="checkbox-delete">
                            </td>
                            <td><?php echo $row['ID']; ?></td>
                            <td><?php echo $row['Nazov']; ?></td>
                            <td><?php echo $row['Kategoria']; ?></td>
                            <td><?php echo $row['Typ']; ?></td>
                            <td><?php echo $row['Cena']; ?></td>
                            <td><?php echo $row['Farba']; ?></td>
                            <td><?php echo $row['Pohlavie']; ?></td>
                            <td><?php echo $row['Obrazok_path']; ?></td>

                            <form action="update.php" method="post">
                                <td>
                                    <a href='update.php?id=<?php echo $id_to_update; ?>' type="button" name="update"><img src="../foto/edit.svg" alt="upraviť" class="update"></a>
                                </td>

                            </form>
                        </tr>
                    <?php endwhile; ?>
                    <tfoot>
                        <tr>
                            <td>
                                <button type="submit" name="delete" id="deleteButton" class="odstranit-btn prvy" onclick="return confirm('Ste si istý že chcete Produkt/y odstrániť ?')">Odstrániť</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>



                <div class="tables-container">
                    <table class="listok">
                        <caption>
                            <h2 class="produkty-nadpis-tabulky">Kategórie</h2>
                        </caption>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Názov kategórie</th>
                            <th></th>
                        </tr>

                        <?php while ($row = mysqli_fetch_array($search_result1)) : ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_ids_kategoria[]" value="<?php echo $row['ID']; ?>" class="checkbox-delete">
                                </td>
                                <td><?php echo $row['ID']; ?></td>
                                <td><?php echo $row['Nazov_kategorie']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tfoot>
                            <tr>
                                <td>
                                    <div>
                                        <button type="submit" name="delete_kategoria" id="deleteButtonKategoria" class="odstranit-btn" onclick="return confirm('Ste si istý že chcete Kategóriu/e odstrániť ?')">Odstrániť</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>


                    <table class="listok">
                        <caption>
                            <h2 class="produkty-nadpis-tybulky">Typy</h2>
                        </caption>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Názov typu</th>
                            <th></th>
                        </tr>
                        <?php while ($row = mysqli_fetch_array($search_result2)) : ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_ids_typy[]" value="<?php echo $row['ID']; ?>" class="checkbox-delete">
                                </td>
                                <td><?php echo $row['ID']; ?></td>
                                <td><?php echo $row['Nazov_typu']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tfoot>
                            <tr>
                                <td>
                                    <div>
                                        <button type="submit" name="delete_typy" id="deleteButtonTypy" class="odstranit-btn" onclick="return confirm('Ste si istý že chcete Typ/y odstrániť ?')">Odstrániť</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                    <table class="listok">
                        <caption>
                            <h2 class="produkty-nadpis-tabulky">Farby</h2>
                        </caption>
                        <tr>
                            <th></th>
                            <th>Id</th>
                            <th>Názov farby</th>
                            <th>Kód farby</th>
                            <th></th>
                        </tr>

                        <?php while ($row = mysqli_fetch_array($search_result3)) : ?>
                            <tr>
                                <td>
                                    <input type="checkbox" name="delete_ids_farba[]" value="<?php echo $row['ID']; ?>" class="checkbox-delete">
                                </td>
                                <td><?php echo $row['ID']; ?></td>
                                <td><?php echo $row['Nazov_farby']; ?></td>
                                <td><?php echo $row['Farba']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        <tfoot>
                            <tr>
                                <td>
                                    <div>
                                        <button type="submit" name="delete_farba" id="deleteButtonFarba" class="odstranit-btn" onclick="return confirm('Ste si istý že chcete Farbu/y odstrániť ?')">Odstrániť</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>

                    </table>

                </div>
            </form>
            <div id="id05" class="modal5">
                <form class="add-content5" action="" method="post">
                    <div>
                        <ul class="ul-add-content5">
                            <li class="li-add-content">
                                <h2 class="produkty-nadpis">Pridanie produktu</h2>
                            </li>
                            <li class="li-add-content-select">
                                <div class="custom-select">
                                    <select name="Kategoria">
                                        <option value="0">Vyberte kategóriu</option>
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
                            <li class="li-add-content-select">
                                <div class="custom-select">
                                    <select name="Typ">
                                        <option value="0">Vyberte typ</option>
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
                            <li class="li-add-content-select">
                                <div class="custom-select">
                                    <select name="Farba">
                                        <option value="0">Vyberte farbu</option>
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

                            <li class="li-add-content">
                                <input type="text" placeholder="Názov" name="Nazov" value="<?php echo $Nazov; ?>" class="add-items" required>
                            </li>
                            <li class="li-add-content">
                                <input type="text" oninput="validateInput(this)" placeholder="Cena" name="Cena" value="<?php echo $Cena; ?>" class="add-items" required>
                            </li>
                            <li class="li-add-content">
                                <input type="file" placeholder="Cesta k obrázku" name="Obrazok_path" value="<?php echo $Obrazok_path; ?>" required>
                            </li>
                            <li class="li-add-content">
                                <input type="text" placeholder="Pohlavie" name="Pohlavie" value="<?php echo $Pohlavie; ?>" class="add-items" required>
                            </li>
                            <li class="li-add-content-btn">
                                <button type="submit" name="add" class="add-btn">Pridať</button>
                                <button onclick="document.getElementById('id05').style.display='none'" class="add-btn">Zrušiť</button>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </main>
        <div>
            <div id="id06" class="modal6">
                <form class="add-content5" action="" method="post">
                    <div>
                        <ul class="ul-add-content5">
                            <li class="li-add-content">
                                <h2 class="produkty-nadpis">Pridanie Kategorie</h2>
                            </li>
                            <li class="li-add-content">
                                <input type="text" placeholder="Kategoria" name="Nazov_kategorie" value="<?php echo $Nazov_kategorie; ?>" class="add-items" required>
                            </li>
                            <li class="li-add-content-btn">
                                <button type="submit" name="add-kategoriu" class="add-btn">Pridať</button>
                                <button onclick="document.getElementById('id06').style.display='none'" class="add-btn">Zrušiť</button>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <div id="id07" class="modal7">
                <form class="add-content5" action="" method="post">
                    <div>
                        <ul class="ul-add-content5">
                            <li class="li-add-content">
                                <h2 class="produkty-nadpis">Pridanie Typu</h2>
                            </li>
                            <li class="li-add-content">
                                <input type="text" placeholder="Typ" name="Nazov_typu" value="<?php echo $Nazov_typu; ?>" class="add-items" required>
                            </li>
                            <li class="li-add-content-btn">
                                <button type="submit" name="add-typ" class="add-btn">Pridať</button>
                                <button onclick="document.getElementById('id07').style.display='none'" class="add-btn">Zrušiť</button>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <div id="id08" class="modal8">
                <form class="add-content5" action="" method="post">
                    <div>
                        <ul class="ul-add-content5">
                            <li class="li-add-content">
                                <h2 class="produkty-nadpis">Pridanie Farby</h2>
                            </li>
                            <li class="li-add-content">
                                <input type="text" placeholder="Názov farby" name="Nazov_farby" value="<?php echo $Nazov_farby; ?>" class="add-items" required>
                            </li>
                            <li class="li-add-content">
                                <input type="text" placeholder="Kód farby" name="Farba_kod" value="<?php echo $Farba_kod; ?>" class="add-items" required>
                            </li>
                            <li class="li-add-content-btn">
                                <button type="submit" name="add-farbu" class="add-btn">Pridať</button>
                                <button onclick="document.getElementById('id08').style.display='none'" class="add-btn">Zrušiť</button>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../javascript/sprava_produktov.js">
    </script>
</body>

</html>