<?php
include 'include/database.php';

session_start();
if (isset($_SESSION["user_role"]) and $_SESSION["user_role"]==1)
    //echo "<p>Διαχειριστικό Ανακοινώσεων <a class='btn btn-primary' href=''>Νέα Ανακοίνωση</a></p>"

    if (isset($_GET['item']))  {
        $newsitem = $conn->query("delete from news where idnews={$_GET['item']}");
    }
header("Location: anakoinosis.php");
