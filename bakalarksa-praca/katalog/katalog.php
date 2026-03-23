<?php
include("../includes/functions.php");
include("../includes/dbh.php");

session_start();

if (isset($_SESSION["MAIL"])) {
    $Mail = $_SESSION["MAIL"];
    $result = mysqli_query($conn, "SELECT * FROM pouzivatelia WHERE Mail = '$Mail'");
    if ($row = mysqli_fetch_array($result)) {
        $Meno = $row['Meno'];
        $Priezvisko = $row['Priezvisko'];
        $Tel_cislo = $row['Tel_cislo'];
        $Mesto = $row['Mesto'];
        $Ulica = $row['Ulica'];
        $Cislo_domu = $row['Cislo_domu'];
        $Psc = $row['Psc'];
    }
}

// Načítanie unikátnych typov produktov z databázy

// Načítanie unikátnych typov produktov z databázy
$typesQuery = "SELECT DISTINCT Nazov_typu FROM typy";
$typesResult = mysqli_query($conn, $typesQuery);

// Načítanie unikátnych kategórií produktov z databázy
$categoriesQuery = "SELECT DISTINCT Nazov_kategorie FROM kategoria";
$categoriesResult = mysqli_query($conn, $categoriesQuery);

// Načítanie unikátnych farieb z databázy
$colorsQuery = "SELECT DISTINCT Nazov_farby, Farba FROM farby";
$colorsResult = mysqli_query($conn, $colorsQuery);


// Spracovanie filtrov z GET
$selectedCategories = $_GET['category'] ?? array();
$selectedColors = $_GET['color'] ?? array();
$selectedTypes = $_GET['type'] ?? array();

// Začiatok tvorby SQL dotazu na produkty
$productsQuery = "SELECT p.* FROM produkty p WHERE 1=1";

// Príprava poľa pre parametre dotazu
$queryParams = array();

if (!empty($selectedCategories)) {
    $productsQuery .= " AND p.Kategoria IN (";
    $productsQuery .= str_repeat('?,', count($selectedCategories) - 1) . '?';
    $productsQuery .= ")";
    $queryParams = array_merge($queryParams, $selectedCategories);
}

if (!empty($selectedColors)) {
    $productsQuery .= " AND p.Farba IN (";
    $productsQuery .= str_repeat('?,', count($selectedColors) - 1) . '?';
    $productsQuery .= ")";
    $queryParams = array_merge($queryParams, $selectedColors);
}

if (!empty($selectedTypes)) {
    $productsQuery .= " AND p.Typ IN (";
    $productsQuery .= str_repeat('?,', count($selectedTypes) - 1) . '?';
    $productsQuery .= ")";
    $queryParams = array_merge($queryParams, $selectedTypes);
}

// Pripravte dotaz s parametrami a vykonajte ho
$statement = mysqli_prepare($conn, $productsQuery);
if ($statement) {
    // Vložte parametre do dotazu
    if (!empty($queryParams)) {
        $typesString = str_repeat('s', count($queryParams));
        mysqli_stmt_bind_param($statement, $typesString, ...$queryParams);
    }
    mysqli_stmt_execute($statement);
    $productsResult = mysqli_stmt_get_result($statement);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creatorshop</title>
    <link rel="stylesheet" href="../css/katalog.css">
</head>

<body>
    <div class="container">
        <header>
            <nav class="menu">
                <div class="top-bar">
                    <div class="prva-casť">
                        <ul class="ul-item-menu">
                            <li class="li-item-menu-logo">
                                <a href="/index.php" class="a-logo">
                                    <h1 class="h1-logo">CreatorShop</h1>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="druha-casť">
                        <ul class="ul-item-menu">
                            <li class="li-item-menu">
                                <a href="../index.php" class="a-domov">Domov</a>
                                <a href="katalog.php" class="a-obchod">Obchod</a>
                                <a href="../fromulare.php" class="a-obchod">Formulare</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tretia-casť">
                        <ul class="ul-item-menu">
                            <li class="li-item-menu-search-line">
                                <a href="cart.php" class="btn-kosik"><img src="../foto/2784211_basket_business_finance_money_icon.png" alt="košík" class="kosik"></a>
                                <input onclick="document.getElementById('id01').style.display='block'" type="submit" name="login" value="" class="img-login">
                                <?php if (isset($_SESSION["MAIL"])) {
                                    if (isset($_POST['upravit'])) {
                                        $Meno = $_POST['Meno'];
                                        $Priezvisko = $_POST['Priezvisko'];
                                        $Tel_cislo = $_POST['Tel_cislo'];
                                        $Mesto = $_POST['Mesto'];
                                        $Ulica = $_POST['Ulica'];
                                        $Cislo_domu = $_POST['Cislo_domu'];
                                        $Psc = $_POST['Psc'];
                                        $result3 = mysqli_query($conn, "UPDATE pouzivatelia SET Meno ='$Meno', Priezvisko = '$Priezvisko' , Tel_cislo = '$Tel_cislo' ,
                                            Mesto = '$Mesto' ,Ulica = '$Ulica', Cislo_domu='$Cislo_domu' , Psc ='$Psc' WHERE Mail = '$Mail'");

                                        if ($result3) {
                                            echo "<script>alert('Účet bol upravený');";
                                            echo "window.location.href = '../index.php';</script>";
                                        } else {
                                            echo "alert('Niečo sa pokazilo')";
                                        }
                                    }
                                ?>
                                    <input onclick="toggleForms('id02')" data-modal="id02" type="submit" name="login" value="" class="img-check">
                                    <div id="id02" class="modal2">
                                        <form class="modal-content2" method="post">
                                            <div>
                                                <ul class="ul-uprava-content">
                                                    <li class="li-uprava-content">
                                                        <div>
                                                            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                                                        </div>
                                                    </li>
                                                    <li class="li-uprava-content-text">
                                                        <label for="Meno" class="uprava-label">Meno:</label>
                                                    </li>
                                                    <li class="li-uprava-content">
                                                        <input type="text" name="Meno" placeholder="Meno" value="<?php echo $Meno; ?>" class="uprava-items" required>
                                                    </li>
                                                    <li class="li-uprava-content-text">
                                                        <label for="Priezvisko" class="uprava-label">Priezvisko:</label>
                                                    </li>
                                                    <li class="li-uprava-content">
                                                        <input type="text" name="Priezvisko" placeholder="Priezvisko" value="<?php echo $Priezvisko; ?>" class="uprava-items" required>
                                                    </li>
                                                    <li class="li-uprava-content-text">
                                                        <label for="Tel_cislo" class="uprava-label">Tel. číslo:</label>
                                                    </li>
                                                    <li class="li-uprava-content">
                                                        <input type="text" oninput="validateInput(this)" name="Tel_cislo" placeholder="Tel. číslo" value="<?php echo $Tel_cislo; ?>" class="uprava-items" title="Prosím zadajte vhodné znaky">
                                                    </li>
                                                    <li class="li-uprava-content-text">
                                                        <label for="Mesto" class="uprava-label">Mesto:</label>
                                                    </li>
                                                    <li class="li-uprava-content">
                                                        <input type="text" name="Mesto" placeholder="Mesto" value="<?php echo $Mesto; ?>" class="uprava-items" required>
                                                    </li>
                                                    <li class="li-uprava-content-text">
                                                        <label for="Ulica" class="uprava-label">Ulica:</label>
                                                    </li>
                                                    <li class="li-uprava-content">
                                                        <input type="text" name="Ulica" placeholder="Ulica" value="<?php echo $Ulica; ?>" class="uprava-items" required>
                                                    </li>
                                                    <li class="li-uprava-content-text">
                                                        <label for="Cislo_domu" class="uprava-label">Číslo domu:</label>
                                                    </li>
                                                    <li class="li-uprava-content">
                                                        <input type="text" oninput="validateInput(this)" name="Cislo_domu" placeholder="Číslo domu" value="<?php echo $Cislo_domu; ?>" class="uprava-items" title="Prosím zadajte vhodné znaky" required>
                                                    </li>
                                                    <li class="li-uprava-content-text">
                                                        <label for="Psc" class="uprava-label">Psč:</label>
                                                    </li>
                                                    <li class="li-uprava-content">
                                                        <input type="text" oninput="validateInput(this)" name="Psc" placeholder="Psč" value="<?php echo $Psc; ?>" class="uprava-items" title="Prosím zadajte vhodné znaky" required>
                                                    </li>
                                                    <li class="li-btn-uprava uprava-btn-first-child">
                                                        <button type="submit" name="upravit" class="uprava-btn">Upraviť</button>
                                                    </li>
                                                    <?php
                                                    if (isset($_SESSION["MAIL"])) {
                                                        $Mail = $_SESSION["MAIL"];
                                                        $result = mysqli_query($conn, "SELECT * FROM pouzivatelia WHERE Mail = '$Mail'");
                                                        if ($row = mysqli_fetch_array($result)) {
                                                            $ID = $row['ID'];
                                                            if ($ID === '3') {  ?>
                                                                <li class="li-btn-uprava-sprava">
                                                                    <a href="sprava_produktov.php" class="uprava-btn-sprava">Správa produktov</a>
                                                                </li>
                                                                <li class="li-btn-uprava-sprava">
                                                                    <a href="objednavky.php" class="uprava-btn-sprava">S. objednávok</a>
                                                                </li>
                                                    <?php
                                                            }
                                                        }
                                                    } ?>
                                                    <li class="li-btn-uprava">
                                                        <a href="../includes/logout.php" class="uprava-btn">Odhlásiť</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </form>
                                    </div>
                            </li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main>
            <hr>
            <div class="row">
                <div class="bocny-stlp">
                    <form action="katalog.php" method="get" class="filter-form">
                        <ul class="bocny-stlp-ul">
                            <li class="bocny-stlp-li" data-attribute="Kategoria">
                                <h2 class="nadpis-filtrovanie">Kategória</h2>
                                <div class="checkbox-group">
                                    <?php while ($categoryRow = mysqli_fetch_array($categoriesResult)) : ?>
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="category[]" value="<?php echo $categoryRow['Nazov_kategorie']; ?>" <?php echo (is_array($selectedCategories) && in_array($categoryRow['Nazov_kategorie'], $selectedCategories)) ? 'checked' : ''; ?>>
                                            <label><?php echo $categoryRow['Nazov_kategorie']; ?></label>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </li>
                            <hr class="katalog-hr">
                            <li class="bocny-stlp-li" data-attribute="Typ">
                                <h2 class="nadpis-filtrovanie">Typ produktu</h2>
                                <div class="checkbox-group">
                                    <?php while ($typeRow = mysqli_fetch_array($typesResult)) : ?>
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="type[]" value="<?php echo $typeRow['Nazov_typu']; ?>" <?php echo (is_array($selectedTypes) && in_array($typeRow['Nazov_typu'], $selectedTypes)) ? 'checked' : ''; ?>>
                                            <label><?php echo $typeRow['Nazov_typu']; ?></label>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </li>
                            <hr class="katalog-hr">
                            <li class="bocny-stlp-li" data-attribute="Farba">
                                <h2 class="nadpis-filtrovanie">Farba</h2>
                                <div class="checkbox-group">
                                    <?php while ($colorRow = mysqli_fetch_array($colorsResult)) : ?>
                                        <div class="checkbox-item">
                                            <input type="checkbox" name="color[]" value="<?php echo $colorRow['Nazov_farby']; ?>" <?php echo (is_array($selectedColors) && in_array($colorRow['Nazov_farby'], $selectedColors)) ? 'checked' : ''; ?>>
                                            <label>
                                                <?php echo $colorRow['Nazov_farby']; ?>
                                                <?php $colorCode = $colorRow['Farba']; ?>
                                                <span class='color-square' style='background-color:<?php echo $colorCode; ?>;'></span>
                                            </label>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </li>
                            <li>
                                <button type="submit" class="btn-filter">Filtrovať</button>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class="produkty-list">

                    <?php while ($row = mysqli_fetch_array($productsResult)) :
                        $id_to_add = $row['ID']; ?>
                        <div class='card'>

                            <h1 class='h1-nazov'><?php echo $row['Nazov']; ?></h1>
                            <img src="../foto/<?php echo $row['Obrazok_path']; ?>" alt='Denim Jeans' class='card-img'>
                            <p class='price'><?php echo $row['Cena']; ?>€</p>
                            <form action="produkt.php" method="post">
                                <a href='produkt.php?id=<?php echo $id_to_add; ?>' type="button" name="update" class="produkt-a">Zobraziť</a>
                            </form>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>

            <div id="id01" class="modal">
                <form class="modal-content animate" action="../includes/login.php" method="post">
                    <div class="preklikavanie-div">
                        <ul class="preklikavanie-ul">
                            <li class="prihlasovanie-li" role="tab">
                                <span onclick="toggleForms('id01', 'id03')" style="width:auto;"><a href="#" style="background-color :white;">Prihlasovanie</a></span>
                            </li>
                            <li class="prihlasovanie-li" role="tab">
                                <span onclick="toggleForms('id03', 'id01')" style="width:auto;"><a href="#">Registrácia</a></span>
                            </li>
                        </ul>
                    </div>
                    <div class="login-content">
                        <ul class="ul-login-content">
                            <li class="li-login-content">
                                <input type="text" placeholder="Email" name="mail" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="password" placeholder="Heslo" name="uzivatelpsw" required class="login-items">
                            </li>
                            <li class="li-login-content-btn">
                                <button type="submit" name="submit" class="login-btn">Prihlásiť</button>
                                <span class="psw"><a href="#" class="login-btn">Zabudli ste heslo ?</a></span>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
            <div id="id03" class="modal3">
                <form class="modal-content3 animate" action="includes/signup.php" method="post">
                    <div class="preklikavanie-div">
                        <ul class="preklikavanie-ul">
                            <li class="prihlasovanie-li" role="tab">
                                <span onclick="toggleForms('id01', 'id03')" style="width:auto;"><a href="#">Prihlasovanie</a></span>
                            </li>
                            <li class="prihlasovanie-li" role="tab">
                                <span onclick="toggleForms('id03', 'id01')" style="width:auto;"><a href="#" style="background-color: white;">Registrácia</a></span>
                            </li>
                        </ul>
                    </div>
                    <div class="login-content">
                        <ul class="ul-login-content">
                            <li class="li-login-content">
                                <input type="text" placeholder="Uživateľské meno" name="meno" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="text" placeholder="Priezvisko" name="priezvisko" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="text" placeholder="Mail" name="mail" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="text" oninput="validateInput(this)" placeholder="Tel. číslo" name="cislo" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="text" placeholder="Mesto" name="mesto" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="text" placeholder="Ulica" name="ulica" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="text" oninput="validateInput(this)" placeholder="Číslo domu" name="cislo_domu" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="text" oninput="validateInput(this)" placeholder="PSC" name="psc" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="password" placeholder="Heslo" name="psw" required class="login-items">
                            </li>
                            <li class="li-login-content">
                                <input type="password" placeholder="Potvrdenie hesla" name="pswrepeat" required class="login-items">
                            </li>
                            <li class="li-login-content-btn">
                                <button type="submit" name="submit" class="login-btn">Registrovať</button>
                                <span onclick="toggleForms('id01', 'id03')" style="width:auto;"><a href="#" class="login-btn">Zrušiť</a></span>
                            </li>
                        </ul>
                    </div>
                </form>
            </div>
        </main>
        <footer>
            <div class="kontakty">
                <p class="p-kontakty">
                    Čislo: +421 987 654 321
                </p>

                <p class="p-kontakty">
                    Mail: CreatorShop@gmail.com
                </p>

                <p class="p-kontakty">
                    <a href="#"><img src="/foto/2959748_instagram_photo_share_icon.png" alt="instagram" class="instagram-icon"></a>
                    <a href="#"><img src="/foto/2959749_facebook_icon.png" alt="facebook" class="facebook-icon"></a>
                </p>
            </div>
        </footer>
    </div>
    <script src="../javascript/katalog.js">
    </script>
</body>

</html>