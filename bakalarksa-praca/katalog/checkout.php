<?php
session_start();
include("../includes/dbh.php");

// Check if the form is submitted
if (isset($_POST['submit_order'])) {
    // Retrieve user information from the form
    $meno = $_POST['meno'];
    $priezvisko = $_POST['priezvisko'];
    $mail = $_POST['mail'];
    $tel_cislo = $_POST['tel_cislo'];
    $mesto = $_POST['mesto'];
    $ulica = $_POST['ulica'];
    $cislo_domu = $_POST['cislo_domu'];
    $psc = $_POST['psc'];

    // Insert each product from the cart into the orders table
    $orderID = uniqid(); // Generate a unique order ID
    foreach ($_SESSION['cart'] as $item) {
        $productId = $item['id'];
        $quantity = $item['quantity'];
        $size = $item['size'];
        $obrazok = $item['obrazok_path'];
        $totalPrice = $item['cena'] * $quantity;
        $insertOrderQuery = "INSERT INTO objednavky (meno, priezvisko, mail, tel_cislo, mesto, ulica, cislo_domu, psc, Pocet, Velkost, Suma, IDproduktu, ID_objednavky) 
                            VALUES ('$meno', '$priezvisko', '$mail', '$tel_cislo', '$mesto', '$ulica', '$cislo_domu', '$psc', '$quantity', '$size', '$totalPrice', '$productId', '$orderID')";
        mysqli_query($conn, $insertOrderQuery);
    }

    // Clear the cart after placing the order
    unset($_SESSION['cart']);

    // Redirect to a thank you page or perform any other action
    echo "<script>alert('Úspešne odoslana objednávka');";
    echo "window.location.href = '../index.php';</script>";
    exit();
}

// Pre-fill user information if the user is logged in

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potvrdenie objedávky</title>
    <link rel="stylesheet" href="../css/check_out.css">
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
                            <a href="katalog.php" class="a-domov">Pokračovať v nakupovaní</a>
                        </li>
                    </ul>
                </div>
                <div class="tretia-casť">
                    <ul class="ul-item-menu">
                        <li class="li-item-menu-search-line">
                            <a href="/katalog/cart.php" class="btn-kosik"><img src="../foto/2784211_basket_business_finance_money_icon.png" alt="košík" class="kosik"></a>
                            <input onclick="toggleForms('id01')" data-modal="id01" type="submit" name="login" value="" class="img-login">
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <hr style="margin-top: 0;">
        <main>
            <h1 class="suma-kosika">Potvrdenie objedávky</h1>
            <div class="cart-checkout">
                <table class="listok">
                    <tr>
                        <th>Názov</th>
                        <th>Kategória</th>
                        <th>Typ</th>
                        <th>Veľkosť</th>
                        <th>Počet</th>
                        <th>Cena za produkt</th>
                        <th>celkova cena</th>
                        <th>obrazok</th>
                    </tr>
                    <?php
                    foreach ($_SESSION['cart'] as $item) {
                        echo "<tr>";
                        echo "<td>" . $item['nazov'] . "</td>";
                        echo "<td>" . $item['kategoria'] . "</td>";
                        echo "<td>" . $item['typ'] . "</td>";
                        echo "<td>" . $item['size'] . "</td>";
                        echo "<td>" . $item['quantity'] . "</td>";
                        echo "<td>" . $item['cena'] . "€</td>";
                        echo "<td>" . $item['cena'] * $item['quantity'] . "€</td>";
                        echo  "<td><img src='../foto/" . $item['obrazok_path'] . "' alt='' style='width:60px; height: auto;'></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>

            <div class="user-info">
                <h1 class="suma-kosika">Informácie o používateľovi</h1>
                <form method="post" class="user-info-form">
                    <?php
                    if (isset($_SESSION["MAIL"])) {
                        $Mail = $_SESSION["MAIL"];
                        $result7 = mysqli_query($conn, "SELECT * FROM pouzivatelia WHERE Mail = '$Mail'");
                        if ($row = mysqli_fetch_array($result7)) {
                            $Meno = $row['Meno'];
                            $Priezvisko = $row['Priezvisko'];
                            $Tel_cislo = $row['Tel_cislo'];
                            $Mesto = $row['Mesto'];
                            $Ulica = $row['Ulica'];
                            $Cislo_domu = $row['Cislo_domu'];
                            $Psc = $row['Psc'];
                    ?>
                            <ul class="ul-item-menu">
                                <li class="li-add-content">
                                    <label for="">Meno:</label>
                                    <input type="text" name="meno" placeholder="Meno" value="<?php echo $Meno; ?>" required>
                                </li>

                                <li class="li-add-content">
                                    <label for="">Priezvisko:</label>
                                    <input type="text" name="priezvisko" placeholder="Priezvisko" value="<?php echo $Priezvisko; ?>" required>
                                </li>

                                <li class="li-add-content">
                                    <label for="">Mail:</label>
                                    <input type="text" name="mail" placeholder="Mail" value="<?php echo $Mail; ?>" required>
                                </li>

                                <li class="li-add-content">
                                    <label for="">Tel. číslo:</label>
                                    <input type="text" name="tel_cislo" placeholder="Tel. číslo" value="<?php echo $Tel_cislo; ?>" required>
                                </li>

                                <li class="li-add-content">
                                    <label for="">Mesto:</label>
                                    <input type="text" name="mesto" placeholder="Mesto" value="<?php echo $Mesto; ?>" required>
                                </li>

                                <li class="li-add-content">
                                    <label for="">Ulica:</label>
                                    <input type="text" name="ulica" placeholder="Ulica" value="<?php echo $Ulica; ?>" required>
                                </li>

                                <li class="li-add-content">
                                    <label for="">Číslo domu:</label>
                                    <input type="text" name="cislo_domu" placeholder="Číslo domu" value="<?php echo $Cislo_domu; ?>" required>
                                </li>

                                <li class="li-add-content">
                                    <label for="">PSČ:</label>
                                    <input type="text" name="psc" placeholder="PSČ" value="<?php echo $Psc; ?>" required>
                                </li>
                            </ul>
                        <?php                     }
                    } else {
                        ?>
                        <ul class="ul-item-menu">
                            <li class="li-add-content">
                                <label for="">Meno:</label>
                                <input type="text" name="meno" placeholder="Meno" required>
                            </li>

                            <li class="li-add-content">
                                <label for="">Priezvisko:</label>
                                <input type="text" name="priezvisko" placeholder="Priezvisko" required>
                            </li>

                            <li class="li-add-content">
                                <label for="">Mail:</label>
                                <input type="text" name="mail" placeholder="Mail" required>
                            </li>

                            <li class="li-add-content">
                                <label for="">Tel. číslo:</label>
                                <input type="text" name="tel_cislo" placeholder="Tel. číslo" required>
                            </li>

                            <li class="li-add-content">
                                <label for="">Mesto:</label>
                                <input type="text" name="mesto" placeholder="Mesto" required>
                            </li>

                            <li class="li-add-content">
                                <label for="">Ulica:</label>
                                <input type="text" name="ulica" placeholder="Ulica" required>
                            </li>

                            <li class="li-add-content">
                                <label for="">Číslo domu:</label>
                                <input type="text" name="cislo_domu" placeholder="Číslo domu" required>
                            </li>

                            <li class="li-add-content">
                                <label for="">PSČ:</label>
                                <input type="text" name="psc" placeholder="PSČ" required>
                            </li>
                        </ul>
                    <?php
                    } ?>

                    <input type="hidden" name="orderID" value="<?php echo $orderID; ?>">
                    <button type="submit" name="submit_order" class="pokracovat-btn">Potvrdiť Objednávku</button>
                </form>
            </div>
            <div id="id01" class="modal">
                <form class="modal-content" action="../includes/login.php" method="post">
                    <div class="preklikavanie-div">
                        <ul class="preklikavanie-ul">
                            <li class="prihlasovanie-li">
                                <span onclick="toggleForms('id01', 'id03')" style="width:auto;"><a href="#" style="background-color: white;">Prihlasovanie</a></span>
                            </li>
                            <li class="prihlasovanie-li">
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
                <form class="modal-content3 " action="../includes/signup.php" method="post">
                    <div class="preklikavanie-div">
                        <ul class="preklikavanie-ul">
                            <li class="prihlasovanie-li">
                                <span onclick="toggleForms('id01', 'id03')" style="width:auto;"><a href="#">Prihlasovanie</a></span>
                            </li>
                            <li class="prihlasovanie-li">
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
    <script src="../javascript/index.js"></script>

</body>

</html>