<?php

if(isset($_POST["submit"])){

    $Mail = $_POST["mail"];
    $psw = $_POST["uzivatelpsw"];

    require_once 'dbh.php';
    require_once 'functions.php';

    if(emptyInputlogin($Mail, $psw)!== false){
        header("location: ../index.php?error=empty-input");
        exit();
    }
    
    loginusers($conn,$Mail, $psw);
}

else{
    header("location ../index.php");
    exit();
}
