<?php
$titlos = 'Καταχώρηση';
include 'header.php';

//session_start(); το session άρχισε από τον header
//print_r($_SESSION);
if (isset($_SESSION["user_id"])) {
    $userID = $_SESSION["user_id"];
    $sql = "SELECT * FROM user WHERE iduser = {$userID}";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $kaysimo = $_POST["kaysimo"];
    $inputprice = $_POST["inputprice"];
    $inputdate = date("Y-m-d", strtotime($_POST["inputdate"]));
    $resultOFFER = $conn->query("SELECT * FROM offer WHERE iduser = '" . $userID . "' and idfuel='" . $_POST["kaysimo"] . "' and date(expire)>= CURRENT_DATE()");
    $userOFFER = $resultOFFER->fetch_assoc();

    if (!empty($userOFFER)) {  //αναρρωτιέμαι αν υπάρχει προσφορά για το καύσιμο
        // υπαρχει προσφορά και ανανεώνω ημερομηνία
        $idoffer = $userOFFER["idoffer"];
        $sql = "Update offer set iduser='$userID', idfuel='$kaysimo', price='$inputprice', expire='$inputdate' where idoffer='$idoffer'";
    } else {
        // δεν υπαρχει προσφορά και δημιουργώ νέα
        $sql = "INSERT INTO offer (iduser, idfuel, price, expire) VALUES ('$userID', '$kaysimo', '$inputprice', '$inputdate')";
    }

    if (mysqli_query($conn, $sql)) { //μηνύματα
        // success
        echo '<p class="badge bg-primary text-wrap fst-italic">Επιτυχής Καταχώρηση</p> ';
        $_POST["kaysimo"] = "";
        $_POST["inputprice"] = "";
        $_POST["inputdate"] = "";
    } else {
        // error
        echo '<p class="badge bg-danger text-wrap fst-italic">Error:' . mysqli_error($conn) . '</p>';
    }
}

?>
<script>
    function validateForm() { //Έλεγχοι απαιτήσεων για κάθε επιμέρους πεδίο

        let x;
        let PriceRegex = /^\d+\.\d{0,2}$/; //τιμή με δεκαδικά
        x = document.forms["form"]["inputprice"].value;
        if (!x.match(PriceRegex)) {
            //Λάθος τιμή
            alert('Λάθος τιμή καυσίμου');
            return false;
        }

        let DateRegex = /([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)([0-9][0-9][0-9][0-9])/;
        x = document.forms["form"]["inputdate"].value;
        if (!x.match(DateRegex)) {
            //Λάθος τιμή
            alert('Λάθος μορφή ημερομηνίας');
            return false;
        }



    }
</script>


<body>

    <br>
    <!-- oρισμός μεγεθων & αποστάσεις  -->
    <?php if (isset($user)) : ?>
        <h1 class="fs-3 ms-4">Καταχώρηση Προσφοράς πρατηρίου <?= htmlspecialchars($user["name"]) ?></h1>
        <br>
        <!--p><a href="logout.php">Log out</a></p-->

        <form name="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" onsubmit="return validateForm()" method="POST">
            <fieldset disabled>
                <div class="form-group row m-0">
                    <label for="inputName" class="col-4 col-form-label"><strong>Επωνυμία Επιχείρησης:</strong></label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputName" placeholder="Επωνυμία" value="<?= $user["name"] ?>">
                    </div>
                </div>


                <div class="form-group row m-0 mt-2">
                    <label for="inputAFM" class="col-4 col-form-label"><strong>ΑΦΜ:</strong></label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputAFM" placeholder="ΑΦΜ" value="<?= $user["afm"] ?>">
                    </div>
                </div>


                <div class="form-group row m-0 mt-2">
                    <label for="inputAddr" class="col-4 col-form-label"><strong>Διεύθυνση</strong></label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="inputAddr" placeholder="Διεύθυνση" value="<?= $user["address"] ?>">
                    </div>
                </div>
            </fieldset>

            <div class="form-group row m-0 mt-2">
                <label for="kaysimo" class="col-form-label col-4"><strong>Είδος Καυσίμου:</strong></label>
                <div class="col-sm-7">
                    <select class="form-select" id="kaysimo" name="kaysimo" aria-label="Καύσιμο" value="<?php echo $_POST["kaysimo"] ?? "" ?>">
                        <?php
                        $fuellist = $conn->query("select idfuel, name from fuel");
                        while ($row = $fuellist->fetch_assoc()) {
                            unset($id, $name);
                            $idfuel = $row['idfuel'];
                            $namefuel = $row['name'];
                            echo '<option value="' . $idfuel . '">' . $namefuel . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>


            <div class="form-group row m-0 mt-2">
                <label for="inputprice" class="col-4 col-form-label"><strong>Τιμή:</strong></label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" name="inputprice" placeholder="Ακέραιος με τελεία και δύο δεκαδικά ψηφία Υ.ΥΥ" required value="<?php echo $_POST["inputprice"] ?? "" ?>">
                    <span id="numberText"></span>
                </div>
            </div>

            <div class="form-group row m-0 mt-2">
                <label for="inputdate" class="col-4 col-form-label"><strong>Ημερομηνία λήξης προσφοράς:</strong></label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="inputdate" id="inputdate" placeholder="ΗΗ-ΜΜ-ΕΕΕΕ" required value="<?php echo $_POST["inputdate"] ?? "" ?>">
                </div>
            </div>
            <br>
            <p class="ms-2">* όλα τα πεδία της φόρμας είναι υποχρεωτικά</p>

            <div class="form-group row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-secondary" name="submit">Καταχώρηση</button>
                </div>
            </div>
        </form>



    <?php else : ?>
        <p>Μπορείτε να προσπελάσετε αυτή την σελίδα επιλέγοντας</p>
        <p><a class="btn btn-primary" href="login.php">Είσοδο</a> ή <a class="btn btn-success" href="eggrafi.php">Εγγραφή</a></p>

    <?php endif; ?>

    <!-- oρισμός υποσελίδου  -->

    <?php include 'footer.php'; ?>

</body>

</html>