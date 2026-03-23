<?php


if (isset($_POST["submit"])){
    $Meno = $_POST["meno"];
    $Priezvisko = $_POST["priezvisko"];
    $Mail = $_POST["mail"];
    $Tel_cislo = $_POST["cislo"];
    $Mesto = $_POST["mesto"];
    $Ulica = $_POST["ulica"];
    $Cislo_domu = $_POST["cislo_domu"];
    $Psc = $_POST["psc"];
    $uzivatelPsw = $_POST["psw"];
    $PswRepeat = $_POST["pswrepeat"];

    require_once 'dbh.php';
    require_once 'functions.php';

    if(emptyInputSignup($Meno, $Priezvisko, $Mail, $Tel_cislo, $Mesto, $Ulica,$Cislo_domu,$Psc,$uzivatelPsw)!== false){
        header("location: ../index.php?error=empty-input");
        exit();
    }

    if(invalidnameofrst($Meno,$Priezvisko)!== false){
        header("location: ../index.php?error=invalid-name-or-surname");
        exit();
    }

    if(invalidemail($Mail)!== false){
        header("location: ../index.php?error=invalid-email");
        exit();
    }

    if(pswMatch($uzivatelPsw, $PswRepeat)!== false){
        header("location: ../index.php?error=passwords-dont-match");
        exit();
    }

    if(nameExists($conn, $Mail)!== false){
        header("location: ../index.php?error=Mail-already-taken");
        exit();
    }
 
    createUser($conn, $Meno, $Priezvisko, $Mail, $Tel_cislo, $Mesto, $Ulica,$Cislo_domu,$Psc,$uzivatelPsw);
}

else {
    echo "<script>alert('Úspešne prihlásený');";
    echo "window.location.href = '../index.php';</script>";
    exit();
}