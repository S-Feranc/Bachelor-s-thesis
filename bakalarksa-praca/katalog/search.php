<?php
include("../includes/dbh.php");
session_start();

function filterTable($query)
{

    include("../includes/dbh.php");
    $filter_Result = mysqli_query($conn, $query);
    return $filter_Result;
}

/* PRODUKTY */

if (isset($_POST['search'])) {
    $valueToSearch = $_POST['valueToSearch'];

    $query = "SELECT * FROM produkty WHERE 
                ID like '%$valueToSearch%'
                or Nazov like '%$valueToSearch%'
                or Kategoria like '%$valueToSearch%'
                or Cena like '%$valueToSearch%'
                or Farba like '%$valueToSearch%'
                or Typ like '%$valueToSearch%'
                or Pohlavie like '%$valueToSearch%'";

    $search_result = filterTable($query);
} else {
    $query = "SELECT * FROM produkty";
    $search_result = filterTable($query);
}


/* KATEGORIE */

    $query = "SELECT * FROM kategoria";
    $search_result1 = filterTable($query);


/* TYPY */

    $query = "SELECT * FROM typy";
    $search_result2 = filterTable($query);


/* FARBY */

    $query = "SELECT * FROM farby";
    $search_result3 = filterTable($query);
