<?php
include 'header.php';

if (isset($_POST['titlos'])) {
    $query = "INSERT INTO news (`title`,`newstext`) VALUES ('{$_POST['titlos']}','{$_POST['keimeno']}')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        echo '<script> alert("Δημοσιεύτηκε"); </script>';
        header('Location: anakoinosis.php');
    } else {
        echo '<script> alert("Δεν δημοσιεύτηκε η ανακοίνωση"); </script>';
    }
}
