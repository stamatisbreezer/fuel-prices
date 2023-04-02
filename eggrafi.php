<?php
$titlos = 'Εγγραφή';
include 'header.php';

$inputName = $inputAFM = $inputAddr = $inputdimos = $inputnomos = $inputemail = $inputuser = $inputPassword1 = $inputPassword2 = '';

$afm = PinakasAFM(); //φορτώνουμε τους ΑΦΜ των εγγεγραμένων

// Form submit
if (isset($_POST['submit'])) {
    $inputName = htmlspecialchars($_POST['inputName']);
    $inputAFM = htmlspecialchars($_POST['inputAFM']);
    $inputAddr = htmlspecialchars($_POST['inputAddr']);
    $inputdimos = htmlspecialchars($_POST['inputdimos']);
    $inputnomos = htmlspecialchars($_POST['inputnomos']);
    $inputemail = htmlspecialchars($_POST['inputemail']);
    $inputuser = htmlspecialchars($_POST['inputuser']);
    $inputPassword1 = $password_hash = password_hash(htmlspecialchars($_POST['inputPassword1']), PASSWORD_DEFAULT);   //Μετατροπή σε hash

    $sql = "INSERT INTO user (name, afm, address, iddimos, idnomos, email, idrole, username, password) VALUES 
    ('$inputName', '$inputAFM', '$inputAddr', '$inputdimos', '$inputnomos','$inputemail',2,'$inputuser','$inputPassword1')";

    if (in_array($inputAFM, $afm)) {
        echo '<p class="badge bg-warning text-wrap fst-italic">Το ΑΦΜ υπάρχει ήδη</p> ';
    } else
   if (mysqli_query($conn, $sql)) {
        // success
        echo '<p class="badge bg-primary text-wrap fst-italic">Επιτυχής Καταχώρηση Επιχείρησης</p> ';
    } else {
        // error
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>

<script>
    function validateForm() { //Έλεγχοι απαιτήσεων για κάθε επιμέρους πεδίο
        let x = document.forms["Regi"]["inputName"].value;
        if (x == "") { //
            alert("Συμπληρώστε όλα τα πεδία");
            return false;
        }


        let AFMpattern = /^\d{9}$/;
        x = document.forms["Regi"]["inputAFM"].value;
        if (!x.match(AFMpattern)) {
            //Το ΑΦΜ πρέπει να έχει 9 αριθμούς
            alert('Προβληματικό ΑΦΜ');
            return false;
        }

        const AFMdata = <?php echo json_encode($afm); ?>; //passing μεταβλητή array afm από func.php στην javascript
        if (AFMdata.includes(x)) {
            //Προσπάθεια Διπλοεγγραφής του ΑΦΜ
            alert('Σφάλμα του ΑΦΜ. Παρακαλώ ελέγξτε το ΑΦΜ και επικοινωνήστε με τον διαχειριστή diax@system.gr');
            return false;
        }


        let EmailRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
        x = document.forms["Regi"]["inputemail"].value;
        if (!x.match(EmailRegex)) {
            //Λάθος τύπος email
            alert('Προβληματικό email');
            return false;
        }

        let passRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
        x = document.forms["Regi"]["inputPassword1"].value;
        if (!x.match(passRegex)) {
            //Το password να είναι 8 χαρακτήρες με ένα κεφαλαίο και ένα αριθμό
            alert('Προβληματικός κωδικός: Τουλάχιστον 8 χαρακτήρας, ένα αριθμό και ένα κεφαλαίο');
            return false;
        }
        let y = document.forms["Regi"]["inputPassword2"].value;
        if (!x == y) {
            //Τα δύο password να είναι ίδια
            alert('Οι κωδικοί δεν είναι ίδιοι');
            return false;
        }

    }




</script>

<body>


    <br>
    <!-- oρισμός μεγεθων & αποστάσεις  -->

    <h1 class="fs-3 ms-4">Εγγραφή Επιχείρησης</h1>
    <br>

    <form name="Regi" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="return validateForm()" method="POST">
        <div class="form-group row m-0">
            <label for="inputName" class="col-4 col-form-label"><strong>Επωνυμία Επιχείρησης:</strong></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="inputName" placeholder="" required>
            </div>
        </div>


        <div class="form-group row m-0 mt-2">
            <label for="inputAFM" class="col-4 col-form-label"><strong>ΑΦΜ:</strong></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="inputAFM" placeholder="Αριθμητικό 9 ψηφίων" required>
            </div>
        </div>

        <div class="form-group row m-0 mt-2">
            <label for="inputAddr" class="col-form-label col-4"><strong>Διεύθυνση:</strong></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="inputAddr" aria-label="Διεύθυνση" required>
            </div>
        </div>

        <div class="form-group row m-0 mt-2">
            <label for="inputnomos" class="col-form-label col-4"><strong>Νομός:</strong></label>
            <div class="col-sm-7" >
                <?php
                $result = $conn->query("select idnomos, name from nomos");
                echo "<select class='form-select' id='inputnomos' name='inputnomos' aria-label='Νομός' onfocus='allagiNomou()'>";
                while ($row = $result->fetch_assoc()) {
                    unset($id, $name);
                    $id = $row['idnomos'];
                    $name = $row['name'];
                    echo '<option value="' . $id . '">' . $name . '</option>';
                }
                ?>
                </select>
            </div>
        </div>

        <div class="form-group row m-0 mt-2">
            <label for="inputdimos" class="col-form-label col-4"><strong>Δήμος:</strong></label>
            <div class="col-sm-7">
                <?php
                $dimoi=array(); //φτιάχνουμε την μεταβλητή που θα περάσει στην javascript για την επιλογή του δήμου
                $result = $conn->query("select iddimos, name, idnomos from dimos");
                echo "<select class= 'form-select' id='inputdimos' name='inputdimos' aria-label='Δήμος' onfocus='allagiNomou()' >";
                while ($row = $result->fetch_assoc()) {
                    unset($id, $name,$new_array_item);
                    $id = $row['iddimos'];
                    $name = $row['name'];

                    $new_array_item=array("iddimos" => $id,"dimosname" => $name, "idnomos" => $row['idnomos']);  //object δήμος για να περάσει
                    array_push($dimoi,$new_array_item); //φτιάχνουμε την μεταβλητή που θα περάσει στην javascript για την επιλογή του δήμου


                    echo '<option value="' . $id . '">' . $name . '</option>';
                }

                ?>
                </select>
            </div>
        </div>



        <div class="form-group row m-0 mt-2">
            <label for="inputemail" class="col-4 col-form-label"><strong>email:</strong></label>
            <div class="col-sm-7">
                <input type="email" class="form-control" name="inputemail" aria-describedby="emailHelp" placeholder="Εισάγετε email" required>
            </div>
        </div>

        <div class="form-group row m-0 mt-2">
            <label for="inputuser" class="col-4 col-form-label"><strong>username:</strong></label>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="inputuser" placeholder="" required>
            </div>
        </div>

        <div class="form-group row m-0 mt-2">
            <label for="inputPassword1" class="col-sm-4 col-form-label"><strong>Κωδικός</strong></label>
            <div class="col-sm-7">
                <input type="password" class="form-control" name="inputPassword1" placeholder="Εισάγετε μυστικό κωδικό" required>
            </div>
        </div>
        <div class="form-group row m-0 mt-2">
            <label for="inputPassword2" class="col-sm-4 col-form-label"><strong>Επιβεβαίωση Κωδικού:</strong></label>
            <div class="col-sm-7">
                <input type="password" class="form-control" name="inputPassword2" placeholder="Εισάγετε ξανά τον μυστικό κωδικό" required>
            </div>
        </div>

        <br><br>
        <p class="ms-2">* όλα τα πεδία της φόρμας είναι υποχρεωτικά</p>


        <div class="form-group row">
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-secondary" name="submit"> Εγγραφή </button>
                <!--input type="submit" value="Submit" onsubmit="validateForm()"-->
            </div>
        </div>
    </form>

    <p id="test"></p>   <!-- testing field -->


    <script >
        //μπαίνει στο τέλος της σελίδας ώστε να έχουν ενημερωθεί η σελίδα και να έχουν οριστεί τα tags

        const Dimosdata = <?php echo json_encode($dimoi) ?>; //passing μεταβλητή array με όλους τους δήμους
        document.getElementById("inputnomos").onchange = function() {allagiNomou()};  //event για να πιάσουμε την αλλαγή του πεδίου Νομός

        function allagiNomou() {  //η συνάρτηση που θα ενημερώνει τα στοιχεία το dropdown list
            let nomos = document.getElementById("inputnomos").value;  //το id του νομού

            let DimosSelected=Dimosdata.filter(dimos => dimos.idnomos === nomos);

            //console.log(DimosSelected);
            //document.getElementById("test").innerHTML = "Selected id: " + nomos +"  --" + DimosSelected;     //testing

            let option = "";
            DimosSelected.forEach((obj, i) => {
                console.log("msgFrom", obj.msgFrom + " msgBody", obj.msgBody);
                option += '<option value="' + obj.iddimos + '">' + obj.dimosname + "</option>"
            });

            document.getElementById("inputdimos").innerHTML = option;   //οριζουμε τις νεες επιλογές του μενού

        }
    </script>

    <!-- oρισμός υποσελίδου  -->
    <?php include 'footer.php'; ?>
</body>

</html>