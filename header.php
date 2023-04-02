<!doctype html>
<html lang="el">

<?php $pagename = basename($_SERVER['PHP_SELF']);  //απαραίτητο για την εμφάνιση της ενεργής σελίδας
require_once  'include/func.php'; //σύνδεση στη βάση και functions
session_start();
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Διαχείριση Υγρών Καυσίμων - <?php echo $titlos; ?></title>
  <link rel="icon" type="image/png" href="fav.ico" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <nav class="navbar navbar-dark navbar-expand-sm text-bg-secondary justify-content-around "><a class="navbar-brand " href="index.php">
      <!-- Λογότυπο που είναι και link προς την αρχική σελίδα -->
      <img src="img/gas-logo.png" alt="Διαχείριση λογότυπο" width="64" height="64" class="d-inline-block align-text-top ms-4">
    </a>

    <!-- oρισμός μπάρας, προσανατολισμός & κενά -->
    <div class="navbar navbar-collapse justify-content-evenly " id="navbarNav">
      <ul class="navbar-nav ">
        <li class="h3 nav-item ">
          <!-- Ορίζω h3 ώστε να έχουμε ιδιότητες μεγέους χωρίς το tag οι επιλογές του μενού-->
          <!-- Ορίζω aria-current για accessibility -->
          <!-- δημιουργία auto-focus menu -->
          <a class="nav-link  <?php if ($pagename == 'index.php') {
                                echo 'active"" aria-current="page" href="#">';
                              } else {
                                echo 'text-bg-secondary" href="index.php">';
                              } ?>   Αρχική</a>  
        </li>
        <li class=" h3 nav-item ">
        <a class=" nav-link <?php if ($pagename == 'anazitisi.php') {
                              echo 'active" aria-current="page" href="#"';
                            } else {
                              echo 'text-bg-secondary" href="anazitisi.php"';
                            } ?>>Αναζήτηση</a>
        </li>

        <li class="h3 nav-item ">
          <a class="nav-link <?php if ($pagename == 'kataxorisi.php') {
                                echo 'active" aria-current="page" href="#"';
                              } else {
                                echo 'text-bg-secondary" href="kataxorisi.php"';
                              } ?>>Καταχώρηση</a>  
        </li>

        <li class=" h3 nav-item ">
        <a class=" nav-link <?php if ($pagename == 'anakoinosis.php') {
                              echo 'active" aria-current="page" href="#"';
                            } else {
                              echo 'text-bg-secondary" href="anakoinosis.php"';
                            } ?>>Ανακοινώσεις</a>
        </li>
      </ul>
    </div>
    <?php
    if (!isset($_SESSION["user_id"]))
      echo "<a href='login.php' class='btn btn-dark navbar-btn px-5 me-4' role='button'>Login</a>";
    else {
      echo "<a href='logout.php' class='btn btn-warning navbar-btn px-5 me-4' role='button'>Log out</a>";
    }
    ?>
  </nav>
</body>