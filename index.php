<?php
$titlos = 'Αρχική';
require_once 'header.php';

$amol[0] = (FuelMin(1));  //αναζήτηση χαμηλότερης τιμής αμόλυβδη ID =1
$amol[1] = (FuelAvg(1));  //αναζήτηση μέσης τιμής
$amol[2] = (FuelMax(1));  //αναζήτηση μέγιστης τιμής
$diesel[0] = (FuelMin(4));  //αναζήτηση χαμηλότερης τιμής diesel ID=4
$diesel[1] = (FuelAvg(4));  //αναζήτηση μέσης τιμής
$diesel[2] = (FuelMax(4));  //αναζήτηση μέγιστης τιμής
$heat[0] = (FuelMin(6));  //αναζήτηση χαμηλότερης τιμής θέρμανση ID=6
$heat[1] = (FuelAvg(6));  //αναζήτηση μέσης τιμής
$heat[2] = (FuelMax(6));  //αναζήτηση μέγιστης τιμής

$anakoinoseis = anakoinoseis();

$inputPassword1 = $password_hash = password_hash(htmlspecialchars('123456aA'), PASSWORD_DEFAULT);   //Μετατροπή σε hash
$sql = "update user set password='{$inputPassword1}'  ";

   if (mysqli_query($conn, $sql)) {
       // success
       //echo '<p class="badge bg-primary text-wrap fst-italic">Επιτυχής Σύνδεση </p> ';
   } else {
       // error
       echo 'Error: ' . mysqli_error($conn);
   }
?>


<body>
  <br>
  <!-- oρισμός μεγεθων & αποστάσεις  -->
  <div class="ms-4 fs-4">
    <h1 class="fs-3 ms-4"> Ημερήσια σύνοψη τιμών</h1>
    <br>
    <h3 class="fs-4 fw-normal ms-4">Τρέχουσα Ημερομηνία</h3>
    <ul class="ms-4">
      <li>
        <h2 class="fs-4">Τιμή αμόλυβδης Βενζίνης 95</h2>
        <p class="lh-1">Μέγιστη: <?php echo $amol[2] . '€ / Ελάχιστη: ' . $amol[0] . '€ / Μέση: ' . $amol[1] . '€';  ?> </p>
      </li>
      <li>
        <h2 class="fs-4">Τιμή πετρελαίου κίνησης</h2>
        <p class="lh-1">Μέγιστη: <?php echo $diesel[2] . '€ / Ελάχιστη: ' . $diesel[0] . '€ / Μέση: ' . $diesel[1] . '€';  ?> </p>
      </li>
      <li>
        <h2 class="fs-4">Τιμή πετρελαίου θέρμανσης</h2>
        <p class="lh-1">Μέγιστη: <?php echo $heat[2] . '€ / Ελάχιστη: ' . $heat[0] . '€ / Μέση: ' . $heat[1] . '€';  ?> </p>
      </li>
    </ul>
    <br>


    <!-- oρισμός μεγεθων & αποστάσεις  -->
    <h1 class="fs-4 ms-4">Τελευταίες Ανακοινώσεις</h1>
    <ul class="ms-4">
      <?php
      $i = 1;
      $anakoinoseis = array_reverse($anakoinoseis); //οι Τελευταίες ανακοινώσεις θέλουμε να εμφανίζονται.
      foreach ($anakoinoseis as $item) : //προσπέλαση των ανακοινώσεων 
      ?>
        <li>
          <h3 class="fs-4 fw-normal lh-1"> <?php
                                            echo hmerominia($item['datenews']);
                                            ?>

          </h3>
        </li>
        <h2 class="fs-4 lh-1"><a href="anakoinosis.php#anakoinosi<?php echo $i ?>"> <?php echo $item['title']; ?> </h2></a>
        <br>


      <?php
        if ($i == 3) break; //μόνο 3 θέλουμε να εμφανίζονται
        $i++;
      endforeach;
      ?>
    </ul>
  </div>
  <br>


  <?php include 'footer.php'; ?>

</body>

</html>