<?php

function emptyInputSignup($Meno, $Priezvisko, $Mail, $Tel_cislo, $Mesto, $Cislo_domu, $Psc, $uzivatelPsw, $PswRepeat){
    $result = null ;

    if(empty($Meno) || empty($Priezvisko) || empty($Mail) || empty($Tel_cislo) || empty($Mesto) || empty($Cislo_domu)|| empty($Psc)|| empty($uzivatelPsw)|| empty($PswRepeat)){
        $result = true;
    }

    else {
        $result = false;
    }
    return $result;
}

function invalidnameofrst($Meno, $Priezvisko){
    $result = null ;

    if(!preg_match("/^[a-zA-Z]/", $Meno)|| !preg_match("/^[a-zA-Z]/",$Priezvisko)) {
        $result = true;
    }
    
    else {
        $result = false;
    }

    return $result;
}

function invalidemail($Mail){
    $result = null ;

    if(!filter_var($Mail, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    }
    
    else {
        $result = false;
    }

    return $result;
}

function pswMatch($uzivatelPsw, $PswRepeat){
    $result = null ;

    if($uzivatelPsw !== $PswRepeat) {
        $result = true;
    }
    
    else {
        $result = false;
    }

    return $result;
}



function createUser($conn, $Meno, $Priezvisko, $Mail, $Tel_cislo, $Mesto, $Ulica,$Cislo_domu,$Psc,$uzivatelPsw){
    $sql = "INSERT INTO pouzivatelia (Meno,Priezvisko,Mail,Tel_cislo,Mesto,Ulica,Cislo_domu,Psc,uzivatelPsw) VALUES (?,?,?,?,?,?,?,?,?) ;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmt-failed");
        exit();
    }

    $hashedPsw = password_hash($uzivatelPsw, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssssss", $Meno, $Priezvisko, $Mail, $Tel_cislo, $Mesto, $Ulica,$Cislo_domu,$Psc, $hashedPsw);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../index.php?error=sign-up-was-successful");
    exit();
}


function emptyInputlogin($Mail, $uzivatelPsw){
    $result = null ;

    if(empty($Mail) || empty($uzivatelPsw)){
        $result = true;
    }

    else {
        $result = false;
    }
    return $result;
}

function nameExists($conn, $Mail){
    $sql = "SELECT * FROM pouzivatelia WHERE Mail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../index.php?error=stmt-failed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $Mail);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }

    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function loginusers($conn,$Mail, $uzivatelPsw){
    $nameExists = nameExists($conn, $Mail);

    if($nameExists === false){
        header("location: ../index.php?error=neexistuje");
        exit();
    }

    $pswHashed = $nameExists["uzivatelPsw"];
    $checkPsw = password_verify($uzivatelPsw, $pswHashed);

    if($checkPsw === false){
        header("location: ../index.php?error=wrong-login");

    }

    else if($checkPsw === true){
        session_start();
        $_SESSION["MAIL"] = $nameExists["Mail"];
        echo "<script>alert('Úspešne prihlásený');";
        echo "window.location.href = '../index.php';</script>";
    }
}