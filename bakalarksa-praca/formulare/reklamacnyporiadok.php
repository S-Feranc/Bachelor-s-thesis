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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creatorshop</title>
    <link rel="stylesheet" href="../css/index.css">
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
                            <a href="../katalog/katalog.php" class="a-obchod">Obchod</a>
                            <a href="../fromulare.php" class="a-domov">Formulare</a>
                        </li>
                    </ul>
                </div>
                <div class="tretia-casť">
                    <ul class="ul-item-menu">
                        <li class="li-item-menu-search-line">
                            <a href="/katalog/cart.php" class="btn-kosik"><img src="../foto/2784211_basket_business_finance_money_icon.png" alt="košík" class="kosik"></a>
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
                                                    $result = mysqli_query($conn, "SELECT * FROM pouzivatelia WHERE Mail = '$Mail'");
                                                    if ($row = mysqli_fetch_array($result)) {
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
        <hr style="margin-top: 0;">
        <main>
            <div>
                    <p>
                        <embed src="Reklama-ny-poriadok-creatorshop.sk.pdf" type="application/pdf" width="800px" height="800px">
                    </p>
            </div>
            <div id="id01" class="modal">
                <form class="modal-content" action="includes/login.php" method="post">
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
                <form class="modal-content3 " action="includes/signup.php" method="post">
                    <div class="preklikavanie-div">
                        <ul class="preklikavanie-ul">
                            <li class="prihlasovanie-li">
                                <span onclick="toggleForms('id01', 'id03')" style="width:auto;"><a href="#">Prihlasovanie</a></span>
                            </li>
                            <li class="prihlasovanie-li">
                                <span onclick="toggleForms('id03', 'id01')" style="width:auto;"><a href="#" style="background-color:white;">Registrácia</a></span>
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

    <script src="/javascript/index.js">
    </script>
</body>

</html>