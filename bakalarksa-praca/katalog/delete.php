<?php
include("../includes/dbh.php");

/* PRODUKTY */
if (isset($_POST['delete'])) {
    if(isset($_POST['delete_ids'])) {
        foreach($_POST['delete_ids'] as $id) {
            $ID = mysqli_real_escape_string($conn, $id);
            $query = "DELETE FROM produkty WHERE ID = '$ID'";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "Error deleting item: " . mysqli_error($conn);
            }
        }
        header("Location: sprava_produktov.php");
        exit();
    } else {
        echo "No items selected for deletion.";
    }
} 

else {
    echo "Delete action not triggered.";
}

/* KATEGORIA */
if (isset($_POST['delete_kategoria'])) {
    if(isset($_POST['delete_ids_kategoria'])) {
        foreach($_POST['delete_ids_kategoria'] as $id) {
            $ID = mysqli_real_escape_string($conn, $id);
            $query = "DELETE FROM kategoria WHERE ID = '$ID'";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "Error deleting item: " . mysqli_error($conn);
            }
        }
        header("Location: sprava_produktov.php");
        exit();
    } else {
        echo "No items selected for deletion.";
    }
} 

else {
    echo "Delete action not triggered.";
}


/* TYPY */
if (isset($_POST['delete_typy'])) {
    if(isset($_POST['delete_ids_typy'])) {
        foreach($_POST['delete_ids_typy'] as $id) {
            $ID = mysqli_real_escape_string($conn, $id);
            $query = "DELETE FROM typy WHERE ID = '$ID'";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "Error deleting item: " . mysqli_error($conn);
            }
        }
        header("Location: sprava_produktov.php");
        exit();
    } else {
        echo "No items selected for deletion.";
    }
} 

else {
    echo "Delete action not triggered.";
}


/*FARBY*/
if (isset($_POST['delete_farba'])) {
    if(isset($_POST['delete_ids_farba'])) {
        foreach($_POST['delete_ids_farba'] as $id) {
            $ID = mysqli_real_escape_string($conn, $id);
            $query = "DELETE FROM farby WHERE ID = '$ID'";
            $result = mysqli_query($conn, $query);
            if (!$result) {
                echo "Error deleting item: " . mysqli_error($conn);
            }
        }
        header("Location: sprava_produktov.php");
        exit();
    } else {
        echo "No items selected for deletion.";
    }
} 

else {
    echo "Delete action not triggered.";
}