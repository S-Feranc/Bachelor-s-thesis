<?php
include("../includes/functions.php");
include("../includes/dbh.php");

session_start();
$id = $_GET['id'];
$query = "SELECT * FROM produkty WHERE ID='$id'";
$result1 = mysqli_query($conn, $query);




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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creatorshop</title>
    <link rel="stylesheet" href="../css/podukt.css">
</head>

<body>
    <div class="container">
        <header>
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
                            <a href="/ ti.php" class="a-velkosti">Veľkosti</a>
                            <a href="/O-nás.php" class="a-o-nas">O nás</a>
                            <a href="#" class="a-kontakt">Kontakt</a>
                        </li>
                    </ul>
                </div>
                <div class="tretia-casť">
                    <ul class="ul-item-menu">
                        <li class="li-item-menu-search-line">
                        <a href="cart.php" class="btn-kosik"><img src="../foto/2784211_basket_business_finance_money_icon.png" alt="košík" class="kosik"></a>
                            <input onclick="toggleForms('id01')" data-modal="id01" type="submit" name="login" value="" class="img-login">
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
                                        echo "window.location.href = 'index.php';</script>";
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
                                                    <label class="uprava-label">Meno:</label>
                                                </li>
                                                <li class="li-uprava-content">
                                                    <input type="text" name="Meno" placeholder="Meno" value="<?php echo $Meno; ?>" class="uprava-items" required>
                                                </li>
                                                <li class="li-uprava-content-text">
                                                    <label class="uprava-label">Priezvisko:</label>
                                                </li>
                                                <li class="li-uprava-content">
                                                    <input type="text" name="Priezvisko" placeholder="Priezvisko" value="<?php echo $Priezvisko; ?>" class="uprava-items" required>
                                                </li>
                                                <li class="li-uprava-content-text">
                                                    <label class="uprava-label">Tel. číslo:</label>
                                                </li>
                                                <li class="li-uprava-content">
                                                    <input type="text" oninput="validateInput(this)" name="Tel_cislo" placeholder="Tel. číslo" value="<?php echo $Tel_cislo; ?>" class="uprava-items" title="Prosím zadajte vhodné znaky">
                                                </li>
                                                <li class="li-uprava-content-text">
                                                    <label class="uprava-label">Mesto:</label>
                                                </li>
                                                <li class="li-uprava-content">
                                                    <input type="text" name="Mesto" placeholder="Mesto" value="<?php echo $Mesto; ?>" class="uprava-items" required>
                                                </li>
                                                <li class="li-uprava-content-text">
                                                    <label class="uprava-label">Ulica:</label>
                                                </li>
                                                <li class="li-uprava-content">
                                                    <input type="text" name="Ulica" placeholder="Ulica" value="<?php echo $Ulica; ?>" class="uprava-items" required>
                                                </li>
                                                <li class="li-uprava-content-text">
                                                    <label class="uprava-label">Číslo domu:</label>
                                                </li>
                                                <li class="li-uprava-content">
                                                    <input type="text" oninput="validateInput(this)" name="Cislo_domu" placeholder="Číslo domu" value="<?php echo $Cislo_domu; ?>" class="uprava-items" title="Prosím zadajte vhodné znaky" required>
                                                </li>
                                                <li class="li-uprava-content-text">
                                                    <label class="uprava-label">Psč:</label>
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
                                                    $result4 = mysqli_query($conn, "SELECT * FROM pouzivatelia WHERE Mail = '$Mail'");
                                                    if ($row = mysqli_fetch_array($result4)) {
                                                        $ID = $row['ID'];
                                                        if ($ID === '3') {  ?>
                                                            <li class="li-btn-uprava-sprava">
                                                                <a href="/katalog/sprava_produktov.php" class="uprava-btn-sprava">Správa produktov</a>
                                                            </li>
                                                <?php
                                                        }
                                                    }
                                                } ?>
                                                <li class="li-btn-uprava">
                                                    <a href="includes/logout.php" class="uprava-btn">Odhlásiť</a>
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
        </header>
        <hr class="hr-produkt">
        <main>
            <form action="cart.php" method="post">
                <?php while ($row = mysqli_fetch_array($result1)) {
                    $Nazov = $row['Nazov'];
                    $Kategoria = $row['Kategoria'];
                    $Typ = $row['Typ'];
                    $Cena = $row['Cena'];
                    $Farba = $row['Farba'];
                    $Obrazok_path = $row['Obrazok_path'];
                    $Pohlavie = $row['Pohlavie'];
                    $id_to_add = $row['ID'];
                 ?>
                <div class="produkt-row">
                    <div class="produkt-photo">
                        <div class='produkt-card-img'>
                            <img src="../foto/<?php echo $Obrazok_path; ?>" alt='Denim Jeans' class='produkt-img'>
                        </div>
                    </div>
                    <div class="produkt-description">
                        <h1 class='produkt-h1-nazov'><?php echo $Nazov; ?></h1>
                        <p class='produkt-price'><?php echo $Cena; ?>€</p>
                        <hr class="produkt-hr">
                        <p class='produkt-kategotia_p'>Pohlavie: <?php echo $Pohlavie; ?></p>
                        <p class='produkt-kategotia_p'>Kategória: <?php echo $Kategoria; ?></p>
                        <p class='produkt-typ_p'>Typ: <?php echo $Typ; ?></p>

                        <p>Vyberte počet:<input type="text" name="quantity" required></p>
                        <p>
                            <select name="size" class="select_velkost" required>
                                <option value="">Vyberte veľkosť</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                            </select>
                        </p>
                        <a href="velkosti" class="velkost">sprievodca veľkosťami</a>
                        <p>
                            <input type="hidden" name="id" value="<?php echo $id_to_add; ?>">
                            <input type="submit" name="add_to_cart" class="produkt-pridat-btn" value="Pridať do košíka">
                        </p>

                        <hr>
                        <p class='produkt-kategotia_p' style="font-size: 15px;">
                            Bezplatné doručenie nad 70 €
                        </p>

                        <p class='produkt-kategotia_p' style="font-size: 15px;">
                            Bezplatné vrátenie v predajniach
                        </p>

                        <p class='produkt-kategotia_p' style="font-size: 15px;">
                            30 dní na výmenu alebo vrátenie
                        </p>

                        <p class='produkt-kategotia_p' style="font-size: 15px;">
                            Špeciálny produkt
                        </p>

                        <hr class="produkt-hr">
                        <h1 class='produkt-h1-nazov'>Popis</h1>
                    </div>
                </div>
                <?php } ?>
            </form>
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

    <script src="/javascript/index.js">
    </script>
</body>

</html>