<?php
include("../includes/dbh.php");


function filterTable($query)
{

    include("../includes/dbh.php");
    $filter_Result = mysqli_query($conn, $query);
    return $filter_Result;
}

$query = "SELECT * FROM objednavky";
$search_result = filterTable($query);

if (isset($_POST['delete'])) {
    if (isset($_POST['delete_ids'])) {
        foreach ($_POST['delete_ids'] as $id) {
            $ID = mysqli_real_escape_string($conn, $id);
            $query = "DELETE FROM objednavky WHERE ID = '$ID'";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "Error deleting item: " . mysqli_error($conn);
            }
        }
        header("Location: objednavky.php");
        exit();
    } else {
        echo "No items selected for deletion.";
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
            <form class="tabulka-form" action="" method="post">
                <table class="listok">
                    <caption>
                        <h2 class="produkty-nadpis-tabulka">Produkty</h2>
                    </caption>
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Meno</th>
                        <th>Priezvisko</th>
                        <th>Číslo</th>
                        <th>Mail</th>
                        <th>Adresa</th>
                        <th>Počet a Veľkosť</th>
                        <th>Suma</th>
                        <th>Produkty</th>
                        <th>ID_objednavky</th>
                        <th></th>
                    </tr>

                    <?php while ($row = mysqli_fetch_array($search_result)) : ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="delete_ids[]" value="<?php echo $row['ID']; ?>" class="checkbox-delete">
                            </td>
                            <td><?php echo $row['ID']; ?></td>
                            <td><?php echo $row['Meno']; ?></td>
                            <td><?php echo $row['Priezvisko']; ?></td>
                            <td><?php echo $row['Tel_cislo']; ?></td>
                            <td><?php echo $row['Mail']; ?></td>
                            <td><?php echo $row['Mesto']; ?> , <?php echo $row['Ulica']; ?> , <?php echo $row['Cislo_domu']; ?> , <?php echo $row['Psc']; ?></td>
                            <td><?php echo $row['Pocet']; ?>ks , <?php echo $row['Velkost']; ?></td>
                            <td><?php echo $row['Suma']; ?>€</td>
                            <td><?php echo $row['IDproduktu']; ?></td>
                            <td><?php echo $row['ID_objednavky']; ?></td>
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
            </form>
        </main>
    </div>
    <script>
        document.getElementById('deleteButton').addEventListener('click', function(event) {
            if (!validateDelete()) {
                event.preventDefault(); // Prevent form submission if validation fails
            }
        });

        function goToHomePage() {
            window.location.href = "katalog.php";
        }
    </script>
</body>

</html>