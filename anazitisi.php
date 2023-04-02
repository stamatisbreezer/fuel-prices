<?php
$titlos = 'Αναζήτηση';
include 'header.php';

if (isset($_POST['searchbutton'])) {
  $inputnomos = $_POST['nomos-select'];
  $inputfuel = $_POST['kaysimo-select'];
} else {
  $inputnomos = 0;
  $inputfuel = 0;
}

?>

<body>

  <br>
  <!-- oρισμός μεγεθων & αποστάσεις  -->

  <h1 class="fs-3 ms-4"> Φίλτρα</h1>

  <form name="Anazitisi" action="" method="POST">

    <!-- ορίζω input group για καλύτερη οπτική ομαδοποίση των στοιχείων ελέγχου-->
    <div class="input-group mb-3 container-fluid ">

      <div class="row g-3 align-items-center">
        <div class="col-auto">
          <label for="nomos-select" class="col-form-label">Νομός</label>
        </div>

        <div class="col-auto">
          <select class='form-select' name='nomos-select' aria-label='Νομός'>
            <option value="0"> </option> //reset form
            <?php
            $nomoslist = $conn->query("select idnomos, name from nomos");
            while ($row = $nomoslist->fetch_assoc()) {
              unset($id, $name);
              $id = $row['idnomos'];
              $name = $row['name'];
              echo '<option value="' . $id . '">' . $name . '</option>';
            }
            ?>
          </select>
        </div>
      </div>


      <div class="row g-3 align-items-center">
        <div class="col-auto ms-2">
          <!-- accessibilyti kaysimo select        -->
          <label class="col-form-label" for="kaysimo-select">Είδος Καυσίμου</label>
        </div>

        <div class="col-auto">
          <select class="form-select" name="kaysimo-select" aria-label="Καύσιμο">
            <option value="0"> </option> //reset form
            <!-- επιλέγω να βάλω εντός την ετικέτα Καύσιμο για καλύτερη αναπαράσταση του πεδίου-->>
            <?php
            $fuellist = $conn->query("select idfuel, name from fuel");
            while ($row = $fuellist->fetch_assoc()) {
              unset($id, $name);
              $id = $row['idfuel'];
              $name = $row['name'];
              echo '<option value="' . $id . '">' . $name . '</option>';
            }
            ?>
          </select>
        </div>
      </div>

      <button class="btn btn-secondary" type="submit" name="searchbutton">Αναζήτηση</button>
    </div>

  </form>

  <br>
  <!-- oρισμός μεγεθων & αποστάσεις  -->
  <h1 class="fs-4 ms-4">Αποτελέσματα</h1>


  <div class="table-wrapper-scroll-y " style="height: 500px;overflow: scroll">
    <table class="table table-bordered m-auto table-striped mb-0 " style="width:90%;">
      <thead>
        <!-- γκρι φόντος και κεντράρισμα τίτλου πίνακα-->
        <tr class="table-secondary text-center ">
          <th scope="col">α/α</th>
          <th scope="col">Επωνυμία</th>
          <th scope="col">Διεύθυνση</th>
          <th scope="col">Τύπος Καυσίμου</th>
          <th scope="col">Τιμή</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $MHTSQL = "select price from OFFER Join user on offer.iduser=user.iduser where user.idnomos=" . $inputnomos . " order by abs(price - " . FuelAvg($inputfuel) . ") limit 1"; //Query για να εντοπίσω τη 1 τιμή με τη μικρότερη διαφορά από την Mέση Hμερήσια Τιμή.
        $MHT = $conn->query($MHTSQL)->fetch_assoc();

        $i = 1;
        // στην διεύθυνση προσθέτω τον δήμο. Αναζητώ προσφορές στο συγκεκριμένο νομό και καύσιμο που να μην έχουν λήξει.
        $sql = "SELECT user.name company,  concat(address,\", \",dimos.name) address, fuel.name fuel, price FROM offer join fuel on offer.idfuel=fuel.idfuel
             join user on offer.iduser=user.iduser join dimos on dimos.iddimos=user.iddimos where fuel.idfuel= " . $inputfuel . " and dimos.idnomos=" . $inputnomos . " and date(expire)>= CURRENT_DATE() ORDER BY PRICE";
        $results = $conn->query($sql);
        while ($row = $results->fetch_assoc()) {
          echo '<tr ';
          if ($MHT['price'] == $row['price']) {
            echo 'class="table-success"';
          } //Πράσινη η γραμμή με τη μικρότερη διαφορά από την Mέση Hμερήσια Τιμή.
          echo '> <th scope="row">' . $i . '</th><td>' . $row['company'] . '</td> <td><a href="https://www.google.com/maps/search/?api=1&query=' . $row['address'] .
            '" target="_blank">' . $row['address'] . '</a></td> <td>' . $row['fuel'] . '</td> <td>' . $row['price'] . '</td></tr>';
          $i++;
        }
        ?>
      </tbody>
    </table>
    <br>
  </div>
  <!-- oρισμός υποσελίδου  -->
  <?php include 'footer.php'; ?>

</body>

</html>