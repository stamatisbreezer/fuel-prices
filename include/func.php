<?php
include_once('database.php');

//echo 'FUNC!! </p>';

function anakoinoseis()
{
    global $conn;
    $sqlnews = 'SELECT * FROM news';
    $result = mysqli_query($conn, $sqlnews);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function hmerominia($stringDate) {  //Για Ελληνικές ημερομηνίες έφτιαξα αυτή την "μεταφραστική"
    $MonthGR = array('Ιανουάριου', 'Φεβρουάριου', 'Μάρτιου', 'Απρίλιου', 'Μάϊου', 'Ιούνιου', 'Ιούλιου', 'Αυγούστου', 'Σεπτεμβρίου', 'Οκτωβρίου', 'Νοεμβρίου', 'Δεκεμβρίου');
    $MonthEN = array('/January/', '/February/', '/March/', '/April/', '/May/', '/June/', '/July/', '/August/', '/September/', '/October/', '/November/', '/December/');

    $DayGR = array('Δευτέρα', 'Τρίτη', 'Τετάρτη', 'Πέμπτη', 'Παρασκευή', 'Σάββατο', 'Κυριακή');
    $DayEN = array('/Monday/', '/Tuesday/', '/Wednesday/', '/Thursday/', '/Friday/', '/Saturday/', '/Sunday/');

    $hmera = preg_replace($MonthEN, $MonthGR, date_format(date_create($stringDate), 'l d F Y G:i ')); //https: //www.w3schools.com/PHP/func_date_date.asp
    $hmera = preg_replace($DayEN, $DayGR, $hmera);

    return $hmera;
}

function FuelMin($FuelType)
{
    global $conn;
    $price = (mysqli_fetch_all(mysqli_query(
        $conn, //μόνο από προσφορές που δεν έχουν λήξει.
        "SELECT MIN(price) minimum FROM offer where idfuel= '" . $FuelType . " and date(expire)>= CURRENT_DATE()'"
    ), MYSQLI_ASSOC));
    return $price[0]["minimum"];
}
function FuelAvg($FuelType)
{
    global $conn;
    $price = (mysqli_fetch_all(mysqli_query(
        $conn,  //μόνο από προσφορές που δεν έχουν λήξει.
        "SELECT AVG(price) average FROM offer where idfuel= '" . $FuelType . " and date(expire)>= CURRENT_DATE()'"
    ), MYSQLI_ASSOC));
    return round($price[0]["average"], 2);
}
function FuelMax($FuelType)
{
    global $conn;
    $price = (mysqli_fetch_all(mysqli_query(
        $conn, //μόνο από προσφορές που δεν έχουν λήξει.
        "SELECT MAX(price) maximum FROM offer where idfuel= '" . $FuelType . " and date(expire)>= CURRENT_DATE()'"
    ), MYSQLI_ASSOC));
    return $price[0]["maximum"];
}

function PinakasAFM()
{ //για έλεγχο στην εγγραφή, φορτώνουμε τους ΑΦΜ της βάσης
    global $conn; //λίστα με όλους τους ΑΦΜ
    $afm = (mysqli_fetch_all(mysqli_query($conn, "SELECT afm FROM user "), MYSQLI_ASSOC));
    return array_column($afm, "afm"); //επιστρέφει μόνο την μια στήλη με τα ΑΦΜ
}
